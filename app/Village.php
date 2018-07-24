<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/26/2017
 * Time: 8:27 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Village extends Model
{

    /**
     * @var string
     */
    protected $table = 'location_villages';

    /**
     * @var array
     */
    protected $fillable = ['id','name','created_at','updated_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getVillage() {
        return $this->hasOne('App\Employee','village_id');
    }
}