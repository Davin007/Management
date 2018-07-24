<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 8/29/2017
 * Time: 10:13 AM
 */

namespace App\Http\Controllers;

use App\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\RedisHandlerTest;


class LeaveController extends Controller
{

    /**
     * LeaveController constructor.
     */
    public function __construct()
    {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->leave = new \App\Leave();
    }

    /**
     * open page leave request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLeave()
    {
        return view('leave.list');
    }

    /**
     * Create dataTable of leave request
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLeaveList(Request $request)
    {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $leave = DB::table('leaves');
        if (isset($keyword) && trim($keyword) != '') {
            $leave->where('leaves.leave_type', 'LIKE', '%' . $keyword . '%')
                ->orwhere('leaves.leave_total_duration', 'LIKE', '%' . $keyword . '%')
                ->orwhere('leaves.leave_description', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $leaveCount = $leave->get()->count();
        $leaves = $leave->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($leaves as $leave) {
            $data[] = [
                'id' => $i++,
                'leave_type' => $leave->leave_type,
                'leave_duration' => $leave->leave_total_duration,
                'leave_description' => $leave->leave_description,
                'action' => $leave = '<i class="fa fa-edit edit-leave pointer btn btn-sm btn-info" id="' . $leave->id . '"></i> <i class="fa fa-trash pointer delete-leave btn btn-sm btn-danger" id="' . $leave->id . '"></i>'
            ];
        }
        $count = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $leaveCount,
            'recordsFiltered' => $leaveCount
        ];
        return response()->json($count);
    }

    /**
     * open form create leave request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddLeave()
    {
        return view('leave.add');
    }

    /**
     * Insert data from input
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function insertLeave(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'leave_type' => 'required|unique:leaves',
                'leave_duration' => 'required',
                'leave_description' => 'required'
            ]);

            if ($validator->fails()) {
                Session::put('errors', $validator->errors()->all());
                return view('message.error');
            }
            $this->leave->leave_type = $request->input('leave_type');
            $this->leave->leave_total_duration = $request->input('leave_duration');
            $this->leave->leave_description = $request->input('leave_description');
            $this->leave->created_at = date('Y-m-d H:i:s');
            $this->leave->created_by = Session::get('user')['user_id'];
            $this->leave->updated_at = null;
            $this->leave->updated_by = Session::get('user')['user_id'];

            if ($this->leave->save()) {
                Session::put('success', 'Successful Created Leave Request');
                return response()->json(['redirect' => '/leave']);
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
     * open form update leave request
     *
     * @param Request $request
     * @return string
     */
    public function getEdit(Request $request)
    {
        $id = $request->input('id');
        $leave = $this->leave->where('id', '=', $id)->get()->first();
        return view('leave.edit')->with('leave', $leave)->render();
    }

    /**
     * update data of leave request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $leave = [
            'leave_type' => $request->input('leave_type'),
            'leave_total_duration' => $request->input('leave_duration'),
            'leave_description' => $request->input('leave_description')
        ];

        $update = $this->leave->where('id', '=', $request->input('id'))->update($leave);
        if ($update) {
            Session::put('success', 'Successful Updated Leave Request');
            return redirect('/leave');
        }
    }

    /**
     * delete leave request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        if ($this->leave->where('id', '=', $id)->delete()) {
            return redirect('/leave');
        }
    }
}