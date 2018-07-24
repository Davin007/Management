<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControllerAction extends Model
{

    protected $table = 'controller_method';

    protected $fillable = ['*'];

    public function getPermission() {
        return $this->hasMany('App\Permission', 'controller_id', 'id');
    }
}
