<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/25/2017
 * Time: 3:00 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\District;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\City;

class DistrictController extends Controller
{
    public $district;

    /**
     * $table
     * @var
     */
    private $table;

    /**
     * DistrictController constructor.
     */
    public function __construct()
    {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->district = new District();
        $this->table = 'location_districts';
        $this->city = new City();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList() {
        $data['data'] = $this->district->get();
        return view('district/list',$data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistrict(Request $request) {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $district = DB::table($this->table);
        if (isset($keyword) && trim($keyword) != '') {
            $district->where('location_districts.name', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $districtCount = $district->get()->count();
        $dist = $district->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($dist as $district) {
            $data[] = [
                'id' => $i++,
                'name' => $district->name,
                'action' => $district = '<i class="fa fa-edit pointer edit-district btn btn-sm btn-info" id="' . $district->id . '"></i> <i class="fa fa-trash pointer delete-district btn btn-sm btn-danger" id="' . $district->id . '"></i>'

            ];

        }

        $districts = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $districtCount,
            'recordsFiltered' => $districtCount
        ];

        return response()->json($districts);
    }

    /**
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd() {
        $data['data'] = $this->city->get()->pluck('name','id');
        return view('district.add',$data);
    }

    /**
     * insert district to database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insertDistrict(Request $request) {
        if($request->ajax()) {
           $validator = Validator::make($request->all(),[
                'name' => 'required',
           ]);
            if ($validator->fails()) {
                Session::put('errors',$validator->errors()->all());
                return view('message.error');
            }
            $this->district->name = $request->input('name');
            $this->district->city_id = $request->input('city_name');
            $this->district->created_at = date('Y-m-d H:i:s');
            $this->district->updated_at = null;

            if ($this->district->save()) {
                Session::put('success','Successful Created District');
                return response()->json(['redirect'=>'/district']);
            }
        }else {
            Session::put('errors',['Method Not Allow']);
            return view('message.error');
        }
    }

    /**
     * get data of district to update
     *
     * @param Request $request
     * @return string
     */
    public function getEdit(Request $request) {
        $id = $request->input('id');
        $district = $this->district->where('id', '=', $id)->get()->first();
        return view('district.edit')->with('district', $district)->render();
    }

    /**
     * update district
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request) {
        $dis = [
            'name' => $request->input('district_name'),
            'updated_at' =>date('Y-m-d H:i:s')
        ];
        $update = $this->district->find($request->input('id'))-> update($dis);
        if($update) {
            Session::put('success','Successful Updated District');
            return redirect('/district');
        }
    }

    /**
     * delete district
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request) {
        $id = $request->input('id');
        if ($this->district->where('id','=',$id)->delete()) {
            return redirect('/district');
        }
    }
}