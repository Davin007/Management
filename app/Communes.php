<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/25/2017
 * Time: 3:28 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Communes extends Model
{

    /**
     * Table
     *
     * @var string $table
     */
    public $table = 'location_communes';

    /**
     * @var array $fillable
     */
    protected $fillable = ['id','name','created_at','updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function getCommune() {
        return $this->hasMany('App\Employee', 'commune_id');
    }
}