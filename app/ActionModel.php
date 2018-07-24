<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 8/17/2017
 * Time: 4:44 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class ActionModel extends Model
{
    use Notifiable;

    protected $table = 'controller_method';

    /**
     * @var array
     */
    protected $fillable = [
        'controller_action','description'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getAccessLink() {
        return $this->hasMany('App\User','id');
    }

}