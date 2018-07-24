<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/7/2017
 * Time: 9:39 AM
 */

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mockery\Recorder;

class RoleController extends Controller
{

    private $role;

    /**
     * RoleController constructor.
     */
    public function __construct() {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->role = new Role();
    }

    /**
     * create dataTable
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRole(Request $request) {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $role = DB::table('roles');
        if (isset($keyword) && trim($keyword) != '') {
            $role->where('roles.role_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('roles.description', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $roleCount = $role->get()->count();
        $roles = $role->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($roles as $role) {
            $data[] = [
                'id' => $i++,
                'role_name' => $role->role_name,
                'description' => $role->description,
                'action' => $role = '<i class="fa fa-edit pointer edit-role btn btn-sm btn-info" id="' . $role->id . '"></i> <i class="fa fa-trash pointer delete-role btn btn-sm btn-danger" id="' . $role->id . '"></i>'

            ];

        }

        $role = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $roleCount,
            'recordsFiltered' => $roleCount
        ];

        return response()->json($role);
    }

    /**
     * get all information of role
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList() {
        $data['data'] = $this->role->get();
        return view('roles.list_role',$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd() {
        return view('roles.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request) {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'role_name' => 'required|unique:roles|Min:3|Max:80',
                'description' => 'required|Max:1000',
            ]);
            if ($validator->fails()) {
                Session::put('errors',$validator->errors()->all());
                return \view('message.error');
            }
            $this->role->role_name = $request->input('role_name');
            $this->role->description = str_limit($request->input('description'));
            $this->role->created_at = date('Y-m-d H:i:s');
            $this->role->level = \App\Permission::isAllowed('users');
            $this->role->created_by = Session::get('user')['user_id'];
            $this->role->updated_at = null;
            $this->role->updated_by = Session::get('user')['user_id'];

            if ($this->role->save()) {
                Session::put('success','Successful Created Role');
                return response()->json(['redirect' => '/roles']);
            } else {
                Session::put('errors',$validator->errors()->all());
                return \view('message.error');
            }
        }else {
            Session::put('errors', ['Method not allowed.']);
            return view('message/error');
        }
    }

    /**
     * get role to update and open form
     *
     * @param Request $request
     * @return string
     */
    public function getEditRole(Request $request) {
        $id = $request->input('id');
        $role = $this->role->where('id', '=', $id)->get()->first();
        return view('roles.edit')->with('role', $role)->render();
    }

    /**
     * update role
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request) {
        $role = [
            'role_name' => $request->input('role_name'),
            'description' => $request->input('description'),
            'updated_at'=> date('Y-m-d H:i:s'),
            'updated_by'=> Session::get('user')['user_id']
        ];
        $update = $this->role->find($request->input('id'))-> update($role);
        if($update) {
                Session::put('success','Successful Update Role');
                return redirect('roles');
        }
    }

    /**
     * delete role
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteRole(Request $request) {
        $id = $request->input('id');
        if ($this->role->where('id', '=', $id)->delete()) {
            return redirect('roles');
        }
    }
}