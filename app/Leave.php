<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 8/29/2017
 * Time: 10:13 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Leave extends Model
{
   use Notifiable;

   protected $table ='leaves';

    /**
     * @var array
     */
   protected $fillable = ['leave_type','leave_total_duration','leave_description'];
}