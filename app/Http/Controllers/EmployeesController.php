<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Village;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\DB;
use App\Employee;
use App\District;
use App\Communes;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class EmployeesController extends Controller
{

    /**
     * @var Employee
     */
    private $employee;

    /**
     * EmployeesController constructor.
     */
    public function __construct()
    {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->employee = new \App\Employee();
        $this->user = new \App\User();
        $this->city = new \App\City();
        $this->district = new \App\District();
        $this->commune = new \App\Communes();
        $this->village = new \App\Village();
    }

    /**
     * get all employee information
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        $data['data'] = $this->employee->get();
        return view('employees.employee_list', $data);
    }

    /**
     * create dataTable
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEmployee(Request $request)
    {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $employee = DB::table('employees')
            ->select('employees.*', 'users.user_full_name', 'users.email', 'location_cities.name AS city_name',
                'location_districts.name AS district_name', 'location_communes.name AS commune_name',
                'location_villages.name AS village_name', 'branches.branch_title AS branch_name',
                'positions.position_title AS position_name', 'departments.department_name')
            ->leftJoin('users', 'users.id', '=', 'employees.user_id')
            ->leftJoin('location_cities', 'employees.city_id', '=', 'location_cities.id')
            ->leftJoin('location_districts', 'employees.district_id', '=', 'location_districts.id')
            ->leftJoin('location_communes', 'employees.commune_id', '=', 'location_communes.id')
            ->leftJoin('location_villages', 'employees.village_id', '=', 'location_villages.id')
            ->leftJoin('branches', 'users.branch_id', '=', 'branches.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id');


        if (isset($keyword) && trim($keyword) != '') {
            $employee->where('employees.sex', 'LIKE', '%' . $keyword . '%')
                ->orwhere('users.user_full_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('location_cities.name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('location_communes.name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('location_districts.name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('location_villages.name', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $employeeCount = $employee->get()->count();
        $employees = $employee->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($employees as $employee) {
            $data[] = [
                'id' => $i++,
                'user_full_name' => $employee->user_full_name,
                'sex' => $employee->sex,
                'email' => $employee->email,
                'city_id' => $employee->city_name,
                'district_id' => $employee->district_name,
                'commune_id' => $employee->commune_name,
                'village_id' => $employee->village_name,
                'branch_id' => $employee->branch_name,
                'position_id' => $employee->position_name,
                'department_id' => $employee->department_name,
                'action' => $employee = '<i class="fa fa-eye pointer detail-employee btn btn-primary btn-sm" id="' . $employee->user_id . '"></i> <i class="fa fa-edit pointer edit-employee btn btn-info btn-sm" id="' . $employee->user_id . '"></i> <i class="fa fa-trash pointer delete-employee  btn btn-sm btn-danger" id="' . $employee->user_id . '"></i>'

            ];
        }
        $employees = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $employeeCount,
            'recordsFiltered' => $employeeCount
        ];
        return response()->json($employees);
    }

    /**
     * open form insert data
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd()
    {
        $department['user_name'] = $this->user->get()->pluck('user_full_name', 'id');
        $department['city'] = $this->city->get()->pluck('name', 'id');
        $department['district'] = $this->district->get()->pluck('name', 'id');
        $department['communes'] = $this->commune->get()->pluck('name', 'id');
        $department['villages'] = $this->village->get()->pluck('name', 'id');
        return view('employees.add', $department);
    }

    /**
     * insert data into database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function save(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|unique:users',
                'house_number' => 'required',
                'house_number' => 'required',
                'street_name' => 'required',
            ]);
            if ($validator->fails()) {
                Session::put('errors',$validator->errors()->all());
                return view('message.error');
            }

            $this->employee->user_id = $request->input('user_name');
            $this->employee->house_number = $request->input('house_number');
            $this->employee->street_name = $request->input('street_name');
            $this->employee->sex = $request->input('gender');
            $this->employee->city_id = $request->input('city');
            $this->employee->district_id = $request->input('district');
            $this->employee->commune_id = $request->input('commune');
            $this->employee->village_id = $request->input('villages');
            $this->employee->created_at = date('Y-m-d H:i:s');
            $this->employee->created_by = Session::get('user')['user_id'];
            $this->employee->updated_at = null;
            $this->employee->updated_by = 0;

            if ($this->employee->save()) {
                Session::put('success','Successful Created Employee');
                return response()->json(['redirect' => '/employees']);
            } else {
                Session::put('errors',$validator->errors()->all());
                return \view('message.error');
            }
        } else {
            Session::put('errors', ['Method not allowed.']);
            return view('message/error');
        }
    }

    /**
     * find location of city,district,commune,village in folder elements
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function findLocation(Request $request)
    {
        $template = $request->input('template');
        $location = $this->district->where('city_id', $request->input('id'))->get();
        switch ($template) {
            case parent::DISTRICT:
                $location = $this->commune->where('district_id', $request->input('id'))->get();
                break;
            case parent::COMMUNE:
                $location = $this->village->where('commune_id', $request->input('id'))->get();
                break;
        }
        $data['locations'] = $location->pluck('name', 'id');
        $data['template'] = $template;
        return view('elements/location/template', $data);
    }

    /**
     * open form for update data of employees
     *
     * @param Request $request
     * @return string
     */
    public function getEdit(Request $request)
    {
        $id = $request->input('id');
        $employee = $this->employee->where('user_id', '=', $id)->get()->first();
        $user = $this->user->where('id', '=', $id)->get()->first();
        $employees['employee'] = $employee;
        $user['data'] = [$user,$employee];
        $employees['city'] = $this->city->get()->pluck('name', 'id');
        $employees['district'] = $this->district->get()->pluck('name', 'id');
        $employees['commune'] = $this->commune->get()->pluck('name', 'id');
        $employees['village'] = $this->village->get()->pluck('name', 'id');
        $user['departments'] = \App\Department::pluck('department_name AS name', 'id');
        $user['positions'] = \App\Position::pluck('position_title AS name', 'id');
        $user['branch'] = \App\Branch::pluck('branch_title', 'id');
        return view('employees.edit', $employees)->with('data', $user)->render();
    }

    /**
     * update user
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $employee = [

            'city_id' => $request->input('city'),
            'district_id' => $request->input('district'),
            'commune_id' => $request->input('commune'),
            'village_id' => $request->input('villages'),
            'sex' => $request->input('gender'),
            'house_number' => $request->input('house_number'),
            'street_name' => $request->input('street_name'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('user')['user_id'],
        ];
        $update = $this->employee->where('user_id', '=', $request->input('id'))->update($employee);
        if ($update) {
            $user = [
                'user_full_name' => $request->input('full_name'),
                'email' => $request->input('email'),
                'department_id' => $request->input('department'),
                'position_id' => $request->input('position'),
                'branch_id' => $request->input('branch'),
            ];
            $update = $this->user->where('id', '=', $request->input('id'))->update($user);
            if ($update) {
                Session::put('success','Successful Update Employee');
                return redirect('/employees');
            }
        }
    }

    /**
     * delete employee
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        if ($this->employee->where('user_id', '=', $id)->delete()) {
            if ($this->user->where('id', '=', $id)->delete()) {
                return \view('users');
            }
        }
    }

    /**
     * view detail employee
     *
     * @param Request $request
     * @return string
     */
    public function detailEmployee(Request $request) {
        $id = $request->input('id');
        $employee = $this->employee->where('user_id', '=', $id)->get()->first();
        $user = $this->user->where('id', '=', $id)->get()->first();
        $employees['employee'] = $employee;
        $user['data'] = [$user,$employee];
        $user['departments'] = \App\Department::pluck('department_name AS name', 'id');
        $user['positions'] = \App\Position::pluck('position_title AS name', 'id');
        $user['branch'] = \App\Branch::pluck('branch_title', 'id');
        return view('employees.detail', $employees)->with('data', $user)->render();
    }
}