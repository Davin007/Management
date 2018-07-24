<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/21/2017
 * Time: 3:27 PM
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\City;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public $city;
    /**
     * $table
     *
     * @var string
     */
    private $table;

    /**
     * CityController constructor.
     */
    public function __construct()
    {
        $this->city = new City();
        $this->table='location_cities';
        $this->middleware(['user.management', 'user.role.permission']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList() {
        return view('city.list_city');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCity(Request $request) {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $city = DB::table($this->table);
        if (isset($keyword) && trim($keyword) != '') {
            $city->where('location_cities.name', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $cityCount = $city->get()->count();
        $cit = $city->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($cit as $city) {
            $data[] = [
                'id' => $i++,
                'name' => $city->name,
                'action' => $city = '<i class="fa fa-edit pointer edit-city btn btn-sm btn-info" id="' . $city->id . '"></i> <i class="fa fa-trash pointer delete-city btn btn-sm btn-danger" id="' . $city->id . '"></i>'

            ];

        }

        $ci = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $cityCount,
            'recordsFiltered' => $cityCount
        ];

        return response()->json($ci);
    }

    /**
     * get form add
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd() {
        return view('city.add');
    }

    /**
     * insert data of city into database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insertCity(Request $request) {
       if ($request->ajax()) {
           $validator = Validator::make($request->all(), [
               'name' => 'required|unique:location_cities',
           ]);
           if ($validator->fails()) {
               Session::put('errors',$validator->errors()->all());
               return view('message.error');
           }
           $this->city->name = $request -> input('name');
           $this->city->created_at = date('Y-m-d H:i:s');
           $this->city->updated_at = null;

           if ($this->city->save()) {
               Session::put('success','Successful Created City');
               return response()->json(['redirect' => '/city']);
           }else {
               Session::put('errors',$validator->errors()->all());
               return \view('message.error');
           }
       }else {
           Session::put('errors',['Method Not Allow']);
           return view('message.error');
       }
    }

    /**
     * get data for update
     *
     * @param Request $request
     * @return string
     */
    public function getEditCity(Request $request) {
        $id = $request->input('id');
        $city = $this->city->where('id', '=', $id)->get()->first();
        return view('city.edit')->with('city', $city)->render();
    }

    /**
     * update city
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateCity(Request $request) {
        $cit = [
            'name' =>$request->input('city_name'),
            'created_at' =>null,
            'updated_at' =>date('Y-m-d H:i:s'),
        ];
        $update = $this->city->find($request->input('id'))->update($cit);
        if ($update) {
            Session::put('success','Successful Update City');
            return redirect('city');
        }
    }

    /**
     * delete city
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request) {
        $id = $request->input('id');
        if ($this->city->where('id', '=', $id)->delete()) {
            return redirect('city');
        }
    }
}