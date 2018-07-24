<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 8/22/2017
 * Time: 8:37 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;

class Permission extends Model
{
    use Notifiable;

    protected $table = 'user_permission';

    /**
     * @var array
     */
    protected $fillable = ['controller_action','description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUser() {
        return $this->belongsTo('App\User','user_id');
    }

    public function getControllerAction() {
        return $this->belongsTo('App\ControllerAction', 'controller_id');
    }

    /**
     * @return bool
     */
    protected static function isAdmin() {
        $user = \App\User::where('user_id', '=', Session::get('user')['user_id'])->select('is_admin')->get()->first();
        if ($user->is_admin) {
            return true;
        }

        return false;
    }

    /**
     * @param $route
     * @return bool
     */
    protected static function isAllowed($route) {
        $routes = self::getAllowedRoutes();
        $actions = [];
        foreach ($routes as $r) {
            $actions[] = $r->controller_action;
        }

        if (self::isAdmin() || in_array('/' . $route, $actions)) {
            return true;
        }

        return false;
    }

    /**
     * @return mixed
     */
    protected static function getAllowedRoutes() {
        $user = \App\User::where('user_id', '=', Session::get('user')['user_id'])->select('id')->get()->first();
        $controller = \App\Permission::where('user_id', '=', $user->id)->get()->first();
        $routes = [];
        if (is_object($controller)) {
            $controller = explode(',', $controller->controller_id);
            $routes = \App\ControllerAction::whereIn('id', $controller)->get();
        }

        return $routes;
    }
}