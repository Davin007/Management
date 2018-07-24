<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/21/2017
 * Time: 3:29 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    /**
     * Table
     *
     * @var string $table
     */
    protected $table = 'location_cities';

    protected $fillable = ['id','name','created_at','updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCity() {
        return $this->hasOne('App\Employee', 'city_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function District() {
        return $this->hasMany('App\District','city_id','id');
    }
}