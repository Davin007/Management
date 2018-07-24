<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();
/*
 * default home page
 */
Route::get('/', 'HomeController@getIndex');//Home page

/*
 * Route for user CRUD User
 */
Route::get('/users', 'UsersController@getList');//get list data of users
Route::post('/api/users/list', 'UsersController@getUsers');//Use dataTable
Route::post('/api/users/get-edit-user', 'UsersController@getEditUser');//for open form edit user
Route::post('/api/users/delete', 'UsersController@deleteUser');
Route::post('/api/users/get-add-user', 'UsersController@getAdd');//open form add user
Route::post('/api/user/insert-user', 'UsersController@save');//insert data into database in users
Route::post('/users/update', 'UsersController@update');
Route::post('/api/users/reset-password', 'UsersController@password');//open form update password
Route::post('/api/password/updatePassword', 'UsersController@updatePassword');//update password
Route::get('/users/login', 'UsersController@getLogin');//open form login
Route::post('/users/login', 'UsersController@postLogin');//login
Route::get('/users/logout', 'UsersController@logout');//logout
Route::post('/api/userProfile/editProfile', 'UsersController@editProfile');//open form edit profile information
Route::post('/api/profile/getProfile', 'UsersController@updateProfile');//update profile
Route::post('/api/profile-password/getProfilePassword', 'UsersController@postPasswordProfile');//open form change profile password
Route::post('/api/password/updateProfilePassword', 'UsersController@postChangePasswordProfile');//for update profile password of user
Route::post('/api/profile/upload', 'UsersController@uploadProfile');
Route::post('api/users-route/get-route','UsersController@getAllRoute');///get all route permission
Route::post('user/set-permission','UsersController@assignPermission');
Route::post('api/users-view/get-view','UsersController@getView');//create user detail info

/*
 * for CRUD Department
 */
Route::get('/department', 'DepartmentController@getList');
Route::post('/api/department/list', 'DepartmentController@getDepartment');//Department dataTable
Route::post('/api/department/get-add-department', 'DepartmentController@getAdd');//open form add department
Route::post('/api/department/create', 'DepartmentController@createDepartment');
Route::post('/api/department/get-edit-department', 'DepartmentController@getEditDepartment');
Route::post('/departments/update', 'DepartmentController@update');
Route::post('/api/department/delete', 'DepartmentController@deleteDepartment');

/*
 * Route for CRUD Position
 */
Route::get('/position', 'PositionController@getList');
Route::post('/api/position/list', 'PositionController@getPosition');//Position DataTable
Route::post('/api/position/get-add-position', 'PositionController@getAdd');
Route::post('/api/position/create-position', 'PositionController@save');//insert data to database
Route::post('/api/position/get-edit-position', 'PositionController@getEditPosition');
Route::post('/positions/update', 'PositionController@update');
Route::post('/api/position/delete', 'PositionController@deletePosition');

/*
 * Route for CRUD Role
 */
Route::get('/roles', 'RoleController@getList');//get list all data from database
Route::post('/api/role/list', 'RoleController@getRole');//Role user DataTable
Route::post('/api/role/get-add-role', 'RoleController@getAdd');//open form for insert data
Route::post('/api/role/create-role', 'RoleController@save');//insert data to database
Route::post('/api/role/get-edit-role', 'RoleController@getEditRole');//open form for update role
Route::post('/role/update', 'RoleController@update');//for update role
Route::post('/api/role/delete', 'RoleController@deleteRole');//for delete role

/*
 *Route For CRUD Branch
 */
Route::get('/branchs', 'BranchController@getList');//list all data from database
Route::post('/api/branch/list', 'BranchController@getBranch');//Create dataTable
Route::post('/api/branch/get-add-branch', 'BranchController@getAdd');//open form add data
Route::post('/api/branch/create-branch', 'BranchController@createBranch');//insert data into database
Route::post('/api/branch/get-edit-branch', 'BranchController@getEditBranch');//for open form edit
Route::post('/branch/update', 'BranchController@update');//update data
Route::post('/api/branch/delete', 'BranchController@deleteBranch');//delete

/*
 * Route for CRUD Employees
 */
Route::get('/employees', 'EmployeesController@getList');//get all data from database
Route::post('/api/employees/employee_list', 'EmployeesController@getEmployee');//Employees dataTable
Route::post('/api/employee/get-add-employee', 'EmployeesController@getAdd');//open form add employee
Route::post('/api/employee/create-employee', 'EmployeesController@save');//insert data into database
Route::post('/api/employee/get-edit-employee', 'EmployeesController@getEdit');//open form update data
Route::post('/employee/update', 'EmployeesController@update');
Route::post('/api/employee/delete', 'EmployeesController@destroy');//delete data
Route::post('/api/employee/detail','EmployeesController@detailEmployee');

/**
 * Route for City
 */
Route::get('/city', 'CityController@getList');
Route::post('/api/city/list', 'CityController@getCity');//for crate dataTable
Route::post('/api/city/get-add-city', 'CityController@getAdd');//open form insert city
Route::post('/api/city/create-city', 'CityController@insertCity');//insert city
Route::post('/api/city/get-edit-city', 'CityController@getEditCity');//open form update city
Route::post('/city/update', 'CityController@updateCity');//update city
Route::post('/api/city/delete', 'CityController@destroy');//destroy city

/**
 * Route for District
 */
Route::get('/district', 'DistrictController@getList');
Route::post('/api/district/list', 'DistrictController@getDistrict');//Create dataTable
Route::post('/api/district/get-add-district', 'DistrictController@getAdd');//open form add district
Route::post('/api/district/create-district', 'DistrictController@insertDistrict');//insert data into district
Route::post('/api/district/get-edit-district', 'DistrictController@getEdit');//open form edit district
Route::post('/district/update', 'DistrictController@update');//update district
Route::post('/api/district/delete', 'DistrictController@destroy');//delete district
Route::post('/api/location/get', 'EmployeesController@findLocation');//get all location

/**
 * Route for Communes
 */
Route::get('/commune', 'CommunesController@getList');
Route::post('/api/commune/list', 'CommunesController@getCommune');//Create dataTable
Route::post('/api/commune/get-add-commune', 'CommunesController@getAdd');//open form commune for add
Route::post('/api/commune/create-commune', 'CommunesController@insert');//insert data into database in communes
Route::post('/api/commune/get-edit-commune', 'CommunesController@getEdit');//get form edit commune
Route::post('/update', 'CommunesController@update');
Route::post('/api/commune/delete', 'CommunesController@destroy');

/**
 * Route for Village
 *
 */
Route::get('/village', 'VillageController@getList');
Route::post('/api/village/list', 'VillageController@getVillage');//Create dataTable
Route::post('/api/village/get-add-village', 'VillageController@getAdd');
Route::post('/api/village/create-village', 'VillageController@insertVillage');
Route::post('/api/village/get-edit-village', 'VillageController@getEdit');
Route::post('/village/update', 'VillageController@updateVillage');
Route::post('/api/village/delete', 'VillageController@destroy');

/**
 * Route Access Link
 */
Route::get('/accessLink','AccessLinkController@getAccessLink');//open page of access link
Route::post('api/access/get-access-list','AccessLinkController@getAccessList');//create dataTable
Route::post('/api/access-link/get-form-add','AccessLinkController@getAdd');//open form add of access link
Route::post('/api/access-link/create-accessLink','AccessLinkController@insertAccessLink');//insert data into table access link
Route::post('/api/access/get-edit-accessLink','AccessLinkController@getEdit');
Route::post('/access/update','AccessLinkController@update');
Route::post('/api/access-link/delete','AccessLinkController@destroy');

Route::get('/permission','PermissionController@getPermission');//open page permission
Route::post('/api/permission/get-permission','PermissionController@getPermissionList');//create dataTable
Route::post('/api/permission/get-add-permission','PermissionController@getAddPermission');//get add form data permission
Route::post('/api/permission/create-permission','PermissionController@insertPermission');
Route::post('/api/edit-permission/get-edit-permission','PermissionController@getEdit');//open form update
Route::post('/permission/update','PermissionController@update');//update permission
Route::post('/api/delete-permission/get-delete-permission','PermissionController@destroy');

/**
 * leave request
 */
Route::get('/leave','LeaveController@getLeave');//open page leave request
Route::post('/api/leave/list','LeaveController@getLeaveList');//Create dataTable of leave request
Route::post('/api/leave/get-add-leave','LeaveController@getAddLeave');//open form create new leave request
Route::post('/api/leave/create-leave','LeaveController@insertLeave');
Route::post('/api/leave/get-edit-leave','LeaveController@getEdit');//open form update leave request
Route::post('/leave/update','LeaveController@update');//update leave
Route::post('/api/leave/get-delete','LeaveController@destroy');//delete leave

/**
 * Route leave status
 *
 */
Route::get('/status','StatusController@getStatus');//open page status
Route::post('/api/status/list','StatusController@getStatusList');//create dataTable of leave status
Route::post('/api/status/get-status','StatusController@getAddStatus');//open form create new status
Route::post('/api/status/create-status','StatusController@insertStatus');//insert data into leave status
Route::post('/api/status/get-edit-status','StatusController@getEdit');//open form update
Route::post('/status/update','StatusController@updateStatus');//update status
Route::post('/api/status/get-delete','StatusController@destroyStatus');
