<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/6/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Http\Request;
use App\Department;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * @var string
     */
    private $department;

    /**
     * DepartmentController constructor.
     */
    public function __construct() {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->department = new Department();
    }

    /**
     * show default table of department
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(){
        $data['data'] = $this->department->get();
        return view('departments.list_department',$data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function getAdd(){
        return view('departments.add');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartment(Request $request) {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $department = DB::table('departments');
        if (isset($keyword) && trim($keyword) != '') {
            $department->where('departments.department_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('departments.department_description', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $departmentCount = $department->get()->count();
        $departments = $department->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($departments as $department) {
            $data[] = [
                'id' => $i++,
                'department_name' => $department->department_name,
                'department_description' => $department->department_description,
                'action' => $department = '<i class="fa fa-edit pointer edit-department btn btn-sm btn-info" id="' . $department->id . '"></i> <i class="fa fa-trash pointer delete-department btn btn-sm btn-danger" id="' . $department->id . '"></i>'

            ];

        }

        $department = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $departmentCount,
            'recordsFiltered' => $departmentCount
        ];

        return response()->json($department);
    }

    /**
     *  save data from input to table in view and database
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createDepartment(Request $request) {

        if ($request->ajax()) {
            $validator = Validator::make($request->all(),[
                'department_name' => 'required|unique:departments|Min:3|Max:50',
                'description' => 'required',
            ]);
            if($validator->fails()) {
                Session::put('errors',$validator->errors()->all());
                    return \view('message.error');
            }

            $this->department->department_name = $request->input('department_name');
            $this->department->department_description = str_limit($request->get('description'),10000);
            $this->department->created_at = date('Y-m-d H:i:s');
            $this->department->created_by =Session::get('user')['user_id'];
            $this->department->updated_at = null;
            $this->department->updated_by = 0;

            if ($this->department->save()) {
                Session::put('success','Successful Created Department');
                return response()->json(['redirect' => '/department']);
            }else {
                Session::put('errors',$validator->errors()->all());
                return \view('message.error');
            }
        } else {
            Session::put('errors', ['Method not allowed.']);
            return view('message/error');
        }
    }

    /**
     * Open form edit data
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getEditDepartment(Request $request) {
        $id = $request->input('id');
        $department = $this->department->where('id', '=', $id)->get()->first();
        return view('departments.edit')->with('department', $department)->render();
    }

    /**
     * function to get data show table
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDepartmentList() {

        $departments = $this->department->get()->take(10);
        $departments = [
            'draw' => 1,
            'data' => $departments,
            'recordsTotal' => $this->department->get()->count(),
            'recordsFiltered' => $this->department->get()->count()
        ];
        return response()->json($departments);
    }

    /**
     * update data
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
   public function update(Request $request) {

       $department = [
           'department_name' => $request->input('department_name'),
           'department_description' => $request->input('description'),
           'updated_at' => date('Y-m-d H:i:s'),
           'updated_by' => Session::get('user')['user_id']
       ];
       $update = $this->department->where('id', '=', $request->input('id'))->update($department);

       if ($update) {
           Session::put('success','Successful Update Department');
           return redirect('department');
       }
   }

    /**
     * delete data
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteDepartment(Request $request)
    {
        $id = $request->input('id');
        if ($this->department->where('id', '=', $id)->delete()) {
            return redirect('department');
        }
    }
}