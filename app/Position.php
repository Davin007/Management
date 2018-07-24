<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/5/2017
 * Time: 3:47 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $fillable = ['position_title', 'position_description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getPosition(){
        return $this->hasOne('App\User','position_id');
    }
}