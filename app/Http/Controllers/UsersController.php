<?php

namespace App\Http\Controllers;

use App\Permission;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Mockery\Exception;
use Sodium\compare;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Session;
use Intervention\Image;

class UsersController extends Controller
{

    /**
     * @var string
     */
    private $user;

    /**
     * UsersController constructor.
     */
    public function __construct()
    {
        $this->user = new \App\User();
        $this->middleware(['user.management', 'user.role.permission'], ['except' => ['getLogin', 'postLogin']]);
    }

    /**
     * Get user list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        $data['data'] = $this->user->get()->first();
        return view('users.list')->with('data', $data)->render();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUsers(Request $request)
    {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $users = DB::table('users')
            ->leftJoin('departments', 'users.department_id', '=', 'departments.id')
            ->leftJoin('positions', 'users.position_id', '=', 'positions.id')
            ->leftJoin('branches', 'users.branch_id', '=', 'branches.id')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id');

        if (isset($keyword) && trim($keyword) != '') {
            $users->where('users.user_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('users.email', 'LIKE', '%'. $keyword . '%')
                ->orWhere('users.user_full_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('departments.department_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('positions.position_title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('roles.role_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('branches.branch_title', 'LIKE', '%' . $keyword . '%');
        }
        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $userCount = $users->get()->count();
        $users = $users->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($users as $user) {
            $action = '';
            $action .= ' <i class="fa fa-eye pointer get-view btn btn-sm btn-primary" id="' . $user->user_id . ' "></i>';
            if (\App\Permission::isAllowed('api/users/reset-password')) {
                $action .= ' <i class="fa fa-key pointer reset-password btn btn-sm btn-warning" id="' . $user->user_id . ' "></i>';
            }

            if (\App\Permission::isAllowed('api/users/get-edit-user')) {
                $action .= ' <i class="fa fa-edit pointer edit-user btn btn-info btn-sm" id="' . $user->user_id . '"></i>';
            }

            if (\App\Permission::isAllowed('api/users/delete')) {
                $action .= ' <i class="fa fa-trash pointer delete-user btn btn-sm btn-danger" id="' . $user->user_id . '"></i> <i class="fa fa-cog pointer get-routes btn btn-sm btn-success" id="' .$user->user_id. '"></i>';
            }
            $data[] = [
                'id' => $i++,
                'user_name' => $user->user_name,
                'user_full_name' => $user->user_full_name,
                'email' => $user->email,
                'department_id' => $user->department_name,
                'position_id' => $user->position_title,
                'role_id' => $user->role_name,
                'branch_id' => $user->branch_title,
                'action' => $action

            ];
        }
        $users = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $userCount,
            'recordsFiltered' => $userCount
        ];
        return response()->json($users);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function getEditUser(Request $request)
    {
        $id = $request->input('id');
        $user = $this->user->where('user_id', '=', $id)->get()->first();
        $user['user'] = $user;
        $user['departments'] = \App\Department::pluck('department_name AS name', 'id');
        $user['positions'] = \App\Position::pluck('position_title AS name', 'id');
        $user['roles'] = \App\Role::pluck('role_name AS name', 'id');
        $user['branchs'] = \App\Branch::pluck('branch_title', 'id');
        return view('users.edit')->with('user', $user)->render();
    }

    /**
     * open form create user
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function getAdd()
    {
        $user['departments'] = \App\Department::pluck('department_name AS name', 'id');
        $user['positions'] = \App\Position::pluck('position_title AS name', 'id');
        $user['roles'] = \App\Role::pluck('role_name AS name', 'id');
        $user['branches'] = \App\Branch::pluck('branch_title', 'id');
        return view('users.add', $user);
    }

    /**
     * insert data to database
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'user_name' => 'required|unique:users|Min:3|Max:20|Alpha',
                'user_full_name' => 'required|Min:3|Max:20',
                'password' => 'required|Between:4,20|same:password_confirmation',
                'password_confirmation' => 'required|Between:4,20'
            ]);
            if ($validator->fails()) {
                Session::put('errors', $validator->errors()->all());
                return \view('message.error');
            }
            $this->user->user_id = $this->user->generateUserId();
            $this->user->user_name = $request->input('user_name');
            $this->user->user_full_name = $request->input('user_full_name');
            $this->user->email = $request->input('email');
            $this->user->user_password = hash('sha256', $request->input('password'));
            $this->user->department_id = $request->input('department');
            $this->user->position_id = $request->input('positions');
            $this->user->role_id = $request->input('role');
            $this->user->is_admin =\App\Permission::isAllowed('users');
            $this->user->branch_id = $request->input('branch');
            $this->user->created_at = date('Y-m-d H:i:s');
            $this->user->created_by = Session::get('user')['user_id'] ;
            $this->user->updated_at = null;

            if ($this->user->save()) {
                Session::put('success', 'Successful Created User');
                return response()->json(['redirect' => '/users']);
            } else {
                Session::put('errors', $validator->errors()->all());
                return \view('message.error');
            }
        } else {
            Session::put('errors', ['Method not allowed.']);
            return view('message/error');
        }
    }

    /**
     * update data of user in database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $user = [
            'user_full_name' => $request->input('full_name'),
            'email' => $request->input('email'),
            'department_id' => $request->input('department'),
            'position_id' => $request->input('position'),
            'role_id' => $request->input('role'),
            'branch_id' => $request->input('branch'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('user')['user_id']
        ];
        $update = $this->user->where('user_id', '=', $request->input('id'))->update($user);
        if ($update) {
            Session::put('success', 'Successful Updated User');
            return redirect('users');
        } else {
            Session::put('errors', $update->errors()->all());
            return \view('users.edit');
        }
    }

    /**
     * open for login
     *
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function getLogin()
    {
        return \view('admin/login_form');
    }

    /**
     * user can login with username and email
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogin(Request $request)
    {
        if ($request->method() == 'POST') {
            $username = $request->input('email');
            $password = hash('sha256', $request->input('password'));
            $user = \App\User::where('user_name', '=', strtolower($username))
                  ->where('user_password', '=', $password)
                  ->orWhere('email', '=', $username)
                  ->get()->first();
            if (count($user) > 0) {
                $request->session()->put('logged_in', true);
                $request->session()->put('user', [
                    'username' => $user->user_name,
                    'email' => $user->email,
                    'user_id' => $user->user_id,
                    'thumbnail' => $user->thumbnail
                ]);
                return redirect('/');
            } else {
                return redirect('users/login');
            }
        }
    }

    /**
     * open form password
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function password(Request $request)
    {
        $id = $request->input('id');
        $user = $this->user->where('id', '=', $id)->get()->first();
        $user['user'] = $user;
        return \view('users/updatePassword')->with('user', $user)->render();
    }

    /**
     * update password
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|View
     */
    public function updatePassword(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'password' => 'required|Between:6,20|same:confirm',
                'confirm' => 'required|Between:6,20'
            ]);
            if ($validator->fails()) {
                Session::put('errors', $validator->errors()->all());
                return \view('message.error');
            }
            $user = ['user_password' => hash('sha256', $request->input('password'))];
            $update = $this->user->where('user_id', '=', $request->input('id'))->update($user);
            if ($update) {
                Session::put('success', 'Successful Change Password');
                return response()->json(['redirect' => '/users']);
            } else {
                Session::put('errors', ['Password can not update']);
                return \view('message.error');
            }
        } else {
            Session::put('errors', ['Method Not Allowed']);
            return \view('message.error');
        }
    }

    /**
     * destroy session to logout system
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Session::forget('logged_in');
        Session::forget('user');
        Session::flush();
        return redirect('/users/login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function deleteUser(Request $request)
    {
        $id = $request->input('id');
        if ($this->user->where('user_id', '=', $id)->delete()) {
            return \view('users');
        }
    }

    /**
     * open form update profile
     *
     * @param Request $request
     * @return string
     */
    public function editProfile(Request $request)
    {
        $id = $request->input('id');
        $user = $this->user->where('user_id', '=', $id)->get()->first();
        return \view('layouts.edit_profile')->with('user', $user)->render();
    }

    /**
     * update profile password and user information
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|View
     */
    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|Between:6,20|same:confirm|different:old_password',
            'confirm' => 'required|Between:6,20'
        ]);
        if ($validator->fails()) {
            Session::put('errors', $validator->errors()->all());
            return \view('message.error');
        } else {
            $oldPassword = hash('sha256', $request->input('old_password'));
            $user = $this->user->where('user_id', '=', $request->input('id'))->get()->first();
            if ($user->user_password === $oldPassword && strlen($user->user_password) === strlen($oldPassword)) {
                $user = [
                    'user_full_name' => $request->input('user_full_name'),
                    'user_password' => hash('sha256', $request->input('new_password')),
                ];
                $update = $this->user->where('user_id', '=', $request->input('id'))->update($user);
                if ($update) {
                    Session::put('success', 'Successful Change Profile');
                    return response()->json(['redirect' => '/users']);
                } else {
                    Session::put('errors', ['Password can not update Profile']);
                    return \view('message.error');
                }
            } else {
                Session::put('errors', ['Old Password incorrect']);
                return \view('message.error');
            }
        }
    }

    /**
     * open form update password in profile
     *
     * @param Request $request
     * @return string
     */
    public function postPasswordProfile(Request $request)
    {
        $id = $request->input('id');
        $user = $this->user->where('user_id', '=', $id)->get()->first();
        return \view('layouts.password_profile')->with('user', $user)->render();
    }

    /**
     * update profile password with current password
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|View
     */
    public function postChangePasswordProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required|Between:6,20|same:confirm|different:old_password',
            'confirm' => 'required|Between:6,20'
        ]);
        if ($validator->fails()) {
            Session::put('errors', $validator->errors()->all());
            return \view('message.error');
        } else {
            $oldPassword = hash('sha256', $request->input('old_password'));
            $user = $this->user->where('user_id', '=', $request->input('id'))->get()->first();
            if ($user->user_password === $oldPassword && strlen($user->user_password) === strlen($oldPassword)) {
                $user = ['user_password' => hash('sha256', $request->input('new_password'))];
                $update = $this->user->where('user_id', '=', $request->input('id'))->update($user);
                if ($update) {
                    Session::put('success', 'Successful Change Password');
                    return response()->json(['redirect' => '/users']);
                } else {
                    Session::put('errors', ['Password can not Change']);
                    return \view('message.error');
                }
            } else {
                Session::put('errors', ['Old Password incorrect']);
                return \view('message.error');
            }
        }
    }

    /**
     * create for upload image of profile
     *
     * @param Request $request
     */
    public function uploadProfile(Request $request)
    {
        if ($request->ajax()) {
            $userId = $request->input('id');
            $thumbnail = $request->file('avatar');
            $name = explode('.', $thumbnail->getClientOriginalName());
            $name = md5(time()) . '.' . strtolower(end($name));
            $msg = ['error' => 1];
            if ($this->user->where('user_id', '=', $userId)->update(['thumbnail' => $name])) {
                if (move_uploaded_file($thumbnail->getPathname(), 'upload/' . $name)) {
                    @unlink('upload/' . $request->session()->get('user')['thumbnail']);
                    $request->session()->put('user.thumbnail', $name);
                    $msg = ['error' => 0, 'file_name' => $name, 'user_id' => $userId];
                }
            }
            echo json_encode($msg);
        }
    }

    /**
     * function create controller permission
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|View
     */
    public function getAllRoute(Request $request) {
        $id = $request->input('id');
        $user['user'] = $this->user->leftJoin('user_permission', 'user_permission.user_id', '=', 'users.id')
            ->select('users.user_id', 'users.id', 'users.email', 'users.user_full_name', 'user_permission.controller_id')
            ->where('users.user_id','=', $id)->get()->first();
        $user['controller_method'] = \App\ControllerAction::select('controller_action', 'id', 'description')->get();
        return \view('users/getRoute',$user);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function assignPermission(Request $request) {
        if ($request->method() == 'POST') {
            $userId = $request->input('user_id');
            $routes = $request->input('routes');
            $route = '';
            foreach ($routes as $item) {
                $route .= $item . ',';
            }

            $permission = new Permission();
            $route = rtrim($route, ',');
            $user = $permission->where(['user_id' => $userId])->get()->first();
            $data = [
                'user_id' => $userId,
                'controller_id' => $route
            ];

            if (count($user) > 0) {
                $update = $permission->where('user_id', '=', $userId)->update($data);
                if ($update) {
                    Session::put('success','Success Updated Permission');
                    return redirect('/users');
                }
            } else {
                if ($permission->insert($data)) {
                    Session::put('success','Success Created Permission');
                    return redirect('/users');
                }
            }
        }
    }

    /**
     * view user detail information
     *
     * @param Request $request
     * @return string
     */
    public function getView(Request $request) {
        $id = $request->input('id');
        $user = $this->user->where('user_id', '=', $id)->get()->first();
        $user['user'] = $user;
        $user['departments'] = \App\Department::pluck('department_name AS name', 'id');
        $user['positions'] = \App\Position::pluck('position_title AS name', 'id');
        $user['roles'] = \App\Role::pluck('role_name AS name', 'id');
        $user['branchs'] = \App\Branch::pluck('branch_title', 'id');
        return view('users.view')->with('user', $user)->render();
    }
}
