<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/5/2017
 * Time: 4:06 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable =['branch_title','description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getBranch(){
        return $this->hasOne('App\User','branch_id');
    }
}