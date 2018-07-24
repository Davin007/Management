<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model {

    protected $fillable = ['department_name', 'department_description'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function getDepartment() {
        return $this->hasOne('App\User', 'department_id');
    }

}