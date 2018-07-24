<?php

namespace App\Http\Controllers;

use App\ActionModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Monolog\Handler\RedisHandlerTest;


class AccessLinkController extends Controller
{

    /**
     * @var ActionModel
     */
    public $controller;

    /**
     * AccessLinkController constructor.
     */
    public function __construct()
    {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->controller = new \App\ActionModel();

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAccessLink() {
        return view('systemManagement/index');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccessList(Request $request) {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $access = DB::table('controller_method');
        if (isset($keyword) && trim($keyword) != '') {
            $access->where('controller_method.controller_action', 'LIKE', '%' . $keyword . '%')
                   ->orwhere('controller_method.description','LIKE', '%'. $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $accessCount = $access->get()->count();
        $access = $access->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($access as $access) {
            $data[] = [
                'id' => $i++,
                'controller_action' => $access->controller_action,
                'description' => $access->description,
                'action' => $access = '<i class="fa fa-edit edit-access-link pointer btn btn-sm btn-info" id="' . $access->id . '"></i> <i class="fa fa-trash pointer delete-accessLink btn btn-sm btn-danger" id="' . $access->id . '"></i>'
            ];
        }
        $access = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $accessCount,
            'recordsFiltered' => $accessCount
        ];
        return response()->json($access);
    }

    /**
     * open form add access link
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd() {
        return view('systemManagement/add');
    }

    /**
     * insert data of access link into database
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function insertAccessLink(Request $request) {
        if($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'controller_action' => 'required',
                'description' => 'required|max:1000'
            ]);
            if ($validator->fails()) {
                Session::put('errors',$validator->errors()->all());
                return view('message.error');
            }

            $this->controller->controller_action = $request->input('controller_action');
            $this->controller->description = $request->input('description');
            $this->controller->created_at = date('Y-m-d H:i:s');
            $this->controller->created_by = Session::get('user')['user_id'];
            $this->controller->updated_at = null;
            $this->controller->updated_by = null;

            if($this->controller->save()) {
                Session::put('success','Successful create user access');
                return response()->json(['redirect' => '/accessLink']);
            } else {
                Session::put('errors',$validator->errors()->all());
                return view('message.error');
            }
        }else {
            Session::put('errors',['Method not allowed']);
            return view('message.error');
        }
    }

    /**
     * get form update
     *
     * @param Request $request
     * @return string
     */
    public function getEdit(Request $request) {
        $id = $request->input('id');
        $controller_access = $this->controller->where('id','=',$id)->get()->first();
        return view('systemManagement.edit')->with('controller_access',$controller_access)->render();
    }

    /**
     * update data
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request) {
        $access_link = [
            'controller_action'=> $request->input('controller_action'),
            'description' => $request->input('description'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('user')['user_id'],
        ];
       $update = $this->controller->find($request->input('id'))->update($access_link);
       if ($update) {
           Session::put('success','Successful update access link');
           return redirect('accessLink');
       } else {
           return redirect('systemManagement.edit');
       }
    }

    public function destroy(Request $request) {
        $id = $request->input('id');
        if ($this->controller->where('id','=',$id)->delete()) {
            return redirect('accessLink');
        }
    }
}