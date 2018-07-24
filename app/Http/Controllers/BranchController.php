<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Branch;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{

    private $branch;

    /**
     * BranchController constructor.
     */
    public function __construct()
    {
        $this->branch = new Branch();
        $this->middleware(['user.management', 'user.role.permission']);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList()
    {
        $data['data'] = $this->branch->get();
        return view('branchs.list_branch', $data);
    }

    /**
     * create dataTable
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBranch(Request $request)
    {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $branch = DB::table('branches');
        if (isset($keyword) && trim($keyword) != '') {
            $branch->where('branches.branch_title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('branches.description', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $branchCount = $branch->get()->count();
        $branches = $branch->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($branches as $branch) {
            $data[] = [
                'id' => $i++,
                'branch_title' => $branch->branch_title,
                'description' => $branch->description,
                'action' => $branch = '<i class="fa fa-edit pointer edit-branch btn btn-sm btn-info" id="' . $branch->id . '"></i> <i class="fa fa-trash pointer delete-branch btn btn-sm btn-danger" id="' . $branch->id . '"></i>'

            ];

        }
        $branch = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $branchCount,
            'recordsFiltered' => $branchCount
        ];

        return response()->json($branch);
    }

    /**
     * open form add branch
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd()
    {
        return view('branchs.add');
    }

    /**
     * insert data into database
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createBranch(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'branch_title' => 'required',
                'description' => 'required|Max:10000'
            ]);
            if ($validator->fails()) {
                Session::put('errors',$validator->errors()->all());
                return view('message.error');
            }
            $this->branch->branch_title = $request->input('branch_title');
            $this->branch->description = str_limit($request->input('description'));
            $this->branch->branch_code = strtoupper(substr($this->branch->branch_title,0,3));
            $this->branch->created_at = date('Y-m-d H:i:s');
            $this->branch->created_by = Session::get('user')['user_id'];
            $this->branch->updated_at = null;
            $this->branch->updated_by = 0;

            if ($this->branch->save()) {
                Session::put('success','Successful Created Branch');
                return response()->json(['redirect' => '/branchs']);
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
     * get data for update
     * @param Request $request
     * @return string
     */
    public function getEditBranch(Request $request)
    {
        $id = $request->input('id');
        $branches = $this->branch->where('id', '=', $id)->get()->first();
        return view('branchs.edit')->with('branches', $branches)->render();
    }

    /**
     * update branch
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $branch = [
            'branch_title' => $request->input('branch_title'),
            'description' => $request->input('description'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('user')['user_id']
        ];
        $update = $this->branch->where('id', '=', $request->input('id'))->update($branch);
        if ($update) {
            Session::put('success','Successful Updated Branch');
            return redirect('branchs');
        }
    }

    /**
     * delete branch
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deleteBranch(Request $request)
    {
        $id = $request->input('id');
        if ($this->branch->where('id', '=', $id)->delete()) {
            return redirect('branchs');
        }
    }
}