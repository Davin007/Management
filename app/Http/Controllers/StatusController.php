<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 8/29/2017
 * Time: 3:10 PM
 */

namespace App\Http\Controllers;

use App\LeaveStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Monolog\Handler\RedisHandlerTest;


class StatusController extends Controller
{

    /**
     * StatusController constructor.
     */
    public function __construct()
    {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->status = new \App\LeaveStatus();
    }

    /**
     * open page status list
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getStatus()
    {
        return view('leaveStatus.list');
    }

    /**
     * create dataTable of leave status
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getStatusList(Request $request)
    {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $status = DB::table('leave_status');
        if (isset($keyword) && trim($keyword) != '') {
            $status->where('leave_status.status_title', 'LIKE', '%' . $keyword . '%')
                ->orwhere('leave_status.status_description', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $statusCount = $status->get()->count();
        $status = $status->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($status as $status) {
            $data[] = [
                'id' => $i++,
                'status_title' => $status->status_title,
                'status_description' => $status->status_description,
                'action' => $status = '<i class="fa fa-edit edit-status pointer btn btn-sm btn-info" id="' . $status->id . '"></i> <i class="fa fa-trash pointer delete-status btn btn-sm btn-danger" id="' . $status->id . '"></i>'
            ];
        }
        $count = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $statusCount,
            'recordsFiltered' => $statusCount
        ];
        return response()->json($count);
    }

    /**
     * open form create new status
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAddStatus()
    {
        return view('leaveStatus.add');
    }

    /**
     * insert data into leave status
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function insertStatus(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'status_title' => 'required|unique:leave_status',
                'status_description' => 'required'
            ]);

            if ($validator->fails()) {
                Session::put('errors', $validator->errors()->all());
                return view('message.error');
            }
            $this->status->status_title = $request->input('status_title');
            $this->status->status_description = $request->input('status_description');
            $this->status->created_at = date('Y-m-d H:i:s');
            $this->status->created_by = Session::get('user')['user_id'];
            $this->status->updated_at = null;
            $this->status->updated_by = 0;

            if ($this->status->save()) {
                Session::put('success', 'Successful Created Leave Status');
                return response()->json(['redirect' => '/status']);
            } else {
                Session::put('errors', $validator->errors()->all());
                return view('message.error');
            }
        } else {
            Session::put('errors', 'Method Not Allowed!');
            return view('message.error');
        }
    }

    /**
     * open form update status
     *
     * @param Request $request
     * @return string
     */
    public function getEdit(Request $request)
    {
        $id = $request->input('id');
        $status = $this->status->where('id', '=', $id)->get()->first();
        return view('leaveStatus.edit')->with('status', $status)->render();
    }

    /**
     * update status
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateStatus(Request $request)
    {
        $status = [
            'status_title' => $request->input('status_title'),
            'status_description' => $request->input('status_description'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('user')['user_id'],
        ];
        
        $update = $this->status->where('id', '=', $request->input('id'))->update($status);
        if ($update) {
            Session::put('success', 'Successful Updated Status');
            return redirect('/status');
        }
    }

    /**
     * delete status
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroyStatus(Request $request)
    {
        $id = $request->input('id');
        if ($this->status->where('id', '=', $id)->delete()) {
            return redirect('/status');
        }
    }
}