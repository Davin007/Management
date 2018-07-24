<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 8/22/2017
 * Time: 8:34 AM
 */

namespace App\Http\Controllers;

use App\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Monolog\Handler\RedisHandlerTest;


class PermissionController extends Controller
{
    /**
     * PermissionController constructor.
     */
    public function __construct()
    {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->controller_permission = new \App\Permission();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPermission()
    {
        return view('permission/list');
    }

    /**
     * create dataTable of permission
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPermissionList(Request $request)
    {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $permission = DB::table('controllers');
        if (isset($keyword) && trim($keyword) != '') {
            $permission->where('controllers.controller_id', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $permissionCount = $permission->get()->count();
        $permissions = $permission->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($permissions as $permission) {
            $data[] = [
                'id' => $i++,
                'controller_id' => $permission->controller_id,
                'action' => $permission = '<i class="fa fa-edit edit-permission pointer btn btn-sm btn-info" id="' . $permission->id . '"></i> <i class="fa fa-trash pointer delete-permission btn btn-sm btn-danger" id="' . $permission->id . '"></i>'
            ];
        }
        $permissions = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $permissionCount,
            'recordsFiltered' => $permissionCount
        ];
        return response()->json($permissions);
    }

    /**
     * open form add permission
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddPermission()
    {
        return view('permission.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function insertPermission(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'controller' => 'required'
            ]);
            if ($validator->fails()) {
                Session::put('errors', $validator->errors()->all());
                return view('message.error');
            }
            $this->controller_permission->controller_id = $request->input('controller');
            $this->controller_permission->created_at = date('Y-m-d H:i:s');
            $this->controller_permission->updated_at = null;

            if ($this->controller_permission->save()) {
                Session::put('success', 'Successful Create Permission');
                return response()->json(['redirect' => '/permission']);
            } else {
                Session::put('errors', $validator->errors()->all());
                return view('message.error');
            }
        } else {
            Session::put('errors', 'Method not allowed');
            return view('message.error');
        }
    }

    /**
     * open form update permission
     *
     * @param Request $request
     * @return string
     */
    public function getEdit(Request $request)
    {
        $id = $request->input('id');
        $permission = $this->controller_permission->where('id', '=', $id)->get()->first();
        return view('permission.edit')->with('permission', $permission)->render();
    }

    /**
     * update permission
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $permission = [
            'controller_id' => $request->input('controller'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('user')['user_id']
        ];
        $update = $this->controller_permission->where('id', '=', $request->input('id'))->update($permission);
        if ($update) {
            Session::put('success', 'Successful Update Permission');
            return redirect('/permission');
        }
    }

    /**
     * destroy permission
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        if ($this->controller_permission->where('id', '=', $id)->delete()) {
            return view('/permission');
        }
    }
}