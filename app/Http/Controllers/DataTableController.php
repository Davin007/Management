<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 6/29/2017
 * Time: 3:42 PM
 */

namespace App\Http\Controllers;


class DataTableController
{
    public function getList()
    {
        return view('datatables.data_table');
    }
}