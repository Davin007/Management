<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/26/2017
 * Time: 8:31 AM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Communes;
use Illuminate\Support\Facades\DB;
use App\Village;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class VillageController extends Controller
{
    public $village;

    /**
     * $table
     *
     * @var
     */
    private $table;

    /**
     * VillageController constructor.
     */
    public function __construct()
    {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->village = new Village();
        $this->table= 'location_villages';
        $this->commune = new Communes();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList() {
        return view('villages.list');
    }

    /**
     * create data table
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVillage(Request $request) {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $village = DB::table($this->table);
        if (isset($keyword) && trim($keyword) != '') {
            $village->where('location_villages.name', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $villageCount = $village->get()->count();
        $village = $village->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($village as $village) {
            $data[] = [
                'id' => $i++,
                'name' => $village->name,
                'action' => $village = '<i class="fa fa-edit pointer edit-village btn btn-sm btn-info" id="' . $village->id . '"></i> <i class="fa fa-trash pointer delete-village btn btn-sm btn-danger" id="' . $village->id . '"></i>'

            ];
        }

        $villages = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $villageCount,
            'recordsFiltered' => $villageCount
        ];

        return response()->json($villages);
    }

    /**
     * open form add
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function getAdd() {
        $data['data'] = $this->commune->get()->pluck('name','id');
        return \view('villages.add',$data);
    }

    /**
     * insert data village into database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function insertVillage(Request $request) {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
            ]);
            if ($validator->fails()) {
                Session::put('errors', $validator->errors()->all());
                return \view('message.error');
            }
            $this->village->name =  $request->input('name');
            $this->village->commune_id = $request->input('commune_name');
            $this->village->created_at = date('Y-m-d H:i:s');
            $this->village->updated_at=null;

            if ($this->village->save()) {
                Session::put('success','Successful Created Village');
                return response()->json(['redirect' => 'village']);
            }
        }else {
            Session::put('errors',['Method Not Allowed']);
            return \view('message.error');
        }
    }

    /**
     * get village to update
     *
     * @param Request $request
     * @return string
     */
    public function getEdit(Request $request) {
        $id = $request->input('id');
        $village = $this->village->where('id','=',$id)->get()->first();
        return \view('villages.edit')->with('village',$village)->render();
    }

    /**
     * update village
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateVillage(Request $request) {
        $village = [
            'name' =>$request->input('village_name'),
            'updated_at' =>date('Y-m-d H:i:s'),
        ];

        $update = $this->village->find($request->input('id'))->update($village);
        if ($update) {
            Session::put('success','Successful Updated Village');
            return redirect('village');
        }
    }

    /**
     * delete village
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request) {
        $id= $request->input('id');
        if($this->village->where('id','=',$id)->delete()) {
            return redirect('village');
        }
    }
}