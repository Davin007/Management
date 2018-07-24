<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    const CITY = 'city';
    const DISTRICT = 'district';
    const COMMUNE = 'commune';
    const VILLAGE = '';

    /**
     * City
     *
     * @var $city
     */
    protected $city;

    /**
     * District
     *
     * @var $district
     */
    protected $district;

    /**
     * Commune
     *
     * @var $commune
     */
    protected $commune;

    /**
     * Village
     *
     * @var $village
     */
    protected $village;

    /**
     * @param Validator $validator
     * @return mixed
     */
    public function formatValidationErrors(Validator $validator) {
        return $validator->errors()->all();
    }
}
