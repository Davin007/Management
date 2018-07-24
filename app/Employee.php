<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/20/2017
 * Time: 2:00 PM
 */

namespace App;


use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable =['user_id','sex','house_number','street_name','email','city_id','district_id','commune_id','village_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getUser() {
        return $this->hasMany('App\User','user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo City
     */
    public function getCity() {
        return $this->belongsTo('App\City','city_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getDistrict() {
        return $this->belongsTo('App\District','district_id','id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function getCommune() {
        return $this->belongsTo('App\Communes','commune_id','id');
    }

}