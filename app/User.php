<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','email','password','user_name','user_full_name, id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getDepartment() {
        return $this->belongsTo('App\Department', 'department_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Position
     */
    public function getPosition() {
        return $this->belongsTo('App\Position', 'position_id', 'id');
    }
    /*
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Role Model
     */
    public function getRole() {
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    /**
     * Belong to Branch model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getBranch() {
        return $this->belongsTo('App\Branch','branch_id','id');
    }

    /**
     * Belong to Employee model
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getEmployee() {
        return $this->belongsTo('App\Employee','user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo ActionModel
     */
    public function getAccessLink() {
        return $this->belongsTo('App\ActionModel','user_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Permission Model
     */
    public function getPermission() {
        return $this->hasMany('App\Permission','user_id','id');
    }
    /**
     * count user id
     *
     * @return string
     */
    public function generateUserId() {
        $start = '000001';
        $user = User::orderBy('id', 'DESC')->first();
        if (count($user) > 0) {
            $id = (int) $user->user_id + 1;

            $strPad = strlen($start) - strlen($id);

            $start = str_pad($id, $strPad + strlen($id), '0', STR_PAD_LEFT);
        }

        return $start;
    }
}
