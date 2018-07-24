<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 8/29/2017
 * Time: 3:12 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LeaveStatus extends Model
{
    use Notifiable;

    /**
     * @var string
     */
    protected $table = 'leave_status';

    /**
     * @var array
     */
    protected $fillable = ['status_title','status_description'];
}