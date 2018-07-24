<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/5/2017
 * Time: 4:03 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = ['role_name', 'description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getRole(){
        return $this->hasOne('App\User','role_id');
    }
}