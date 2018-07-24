<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/25/2017
 * Time: 3:02 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    /**
     * Table
     *
     * @var string $table
     */
    protected $table = 'location_districts';

    /**
     * @var array
     */
    protected $fillable =['id','name','created_at','updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getDistrict() {
        return $this->hasOne('App\Employee','district_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCity() {
        return $this->belongsTo('App\City','city_id');
    }
}