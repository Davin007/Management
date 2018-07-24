<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/25/2017
 * Time: 3:27 PM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\District;
use App\Employee;
use Illuminate\Http\Request;
use App\Communes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class CommunesController extends Controller
{

    /**
     * Communes
     *
     * @var Communes
     */
    public $communes;

    /**
     * CommunesController constructor.
     */
    public function __construct()
    {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->communes = new Communes();
        $this->district = new District();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList() {
        $data['data'] = DB::table('location_communes')->get();
//        var_dump(count($data));die();
        return view('communes/list');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCommune(Request $request) {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $communes = DB::table($this->communes->table);
        if (isset($keyword) && trim($keyword) != '') {
            $communes->where('location_communes.name', 'LIKE', '%' . $keyword . '%');
        }
        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $communeCount = $communes->get()->count();
        $communes = $communes->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($communes as $commune) {
            $data[] = [
                'id' => $i++,
                'name' => $commune->name,
                'action' => $commune = '<i class="fa fa-edit pointer edit-commune btn btn-sm btn-info" id="' . $commune->id . '"></i> <i class="fa fa-trash pointer delete-commune btn btn-sm btn-danger" id="' . $commune->id . '"></i>'

            ];

        }
        $commune = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $communeCount,
            'recordsFiltered' => $communeCount
        ];
        return response()->json($commune);
    }

    /**
     * open form add
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function getAdd() {
        $data['data'] = $this->district->get()->pluck('name','id');
        return view('communes.add',$data);
    }

    /**
     * insert data to database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insert(Request $request) {
        if ($request->ajax()){
            $validator = Validator::make($request->all(),[
                'name' => 'Required|unique:location_communes'
            ]);
            if ($validator->fails()) {
                Session::put('errors',$validator->errors()->all());
                return \view('message.error');
            }
            $this->communes-> name = $request -> input('name');
            $this->communes-> district_id = $request->input('district_name');
            $this->communes-> created_at = date('Y-m-d H:i:s');
            $this->communes-> updated_at = null;
            if ($this->communes-> save()) {
                Session::put('success','Successful Created Commune');
                return response()->json(['redirect' => '/commune']);
            }
        }else {
            Session::put('errors',['Method Not Allowed']);
            return \view('message.errors');
        }
    }

    /**
     * get form update data
     *
     * @param Request $request
     * @return string
     */
    public function getEdit(Request $request) {
        $id = $request->input('id');
        $commune = $this->communes->where('id','=',$id)->get()->first();
        return \view('communes.edit')->with('commune',$commune)->render();
    }

    /**
     * update information of communes
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request) {
        $commun = [
          'name' =>$request->input('commune_name'),
          'created_at' =>null,
          'updated_at' =>date('Y-m-d H:i:s'),
        ];
        $update = $this->communes->find($request->input('id'))->update($commun);
        if ($update) {
            Session::put('success','Successful Updated Commune');
            return redirect('commune');
        }
    }

    /**
     * delete commune
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request) {
        $id = $request->input('id');
        if ($this->communes->where('id','=',$id)->delete()) {
            return redirect('commune');
        }
    }
}