<?php
/**
 * Created by PhpStorm.
 * User: Vin TOUCH
 * Date: 7/6/2017
 * Time: 4:31 PM
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\App;
use App\Position;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class PositionController extends Controller
{

    private $position;


    public function __construct() {
        $this->middleware(['user.management', 'user.role.permission']);
        $this->position = new Position();
    }

    /**
     * Create dataTable
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPosition(Request $request) {
        $offset = $request->input('start');
        $limit = $request->input('length');
        $keyword = $request->input('search');
        $keyword = strtolower($keyword['value']);
        $position = DB::table('positions');
        if (isset($keyword) && trim($keyword) != '') {
            $position->where('positions.position_title', 'LIKE', '%' . $keyword . '%')
                ->orWhere('positions.position_description', 'LIKE', '%' . $keyword . '%');
        }

        $columns = $request->input('order');
        $columnIndex = $request->input('columns');
        $columnIndex = $columnIndex[$columns[0]['column']]['data'] == 'id' ? $columnIndex[1]['data'] : $columnIndex[$columns[0]['column']]['data'];
        $orderType = $columns[0]['dir'];
        $positionCount = $position->get()->count();
        $positions = $position->skip($offset)->take($limit)->orderBy($columnIndex, $orderType)->get();
        $data = [];
        $i = $offset > 0 ? ($offset + 1) : 1;
        foreach ($positions as $position) {
            $data[] = [
                'id' => $i++,
                'position_title' => $position->position_title,
                'position_description' => $position->position_description,
                'action' => $position = '<i class="fa fa-edit pointer edit-position btn btn-sm btn-info" id="' . $position->id . '"></i> <i class="fa fa-trash pointer delete-position btn btn-sm btn-danger" id="' . $position->id . '"></i>'

            ];

        }

        $position = [
            'draw' => $request->input('draw') ?? 0,
            'data' => $data,
            'recordsTotal' => $positionCount,
            'recordsFiltered' => $positionCount
        ];

        return response()->json($position);
    }

    /**
     *Get list data of position in dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList() {
        $data['data'] = $this->position->get();
        return view('positions/list_position',$data);
    }

    /**
     * open form create position
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd() {
        return view('positions.add');
    }

    /**
     * function create new position
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function save(Request $request) {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'position_title' => 'required|unique:positions|Min:3|Max:80',
                'description' => 'required|Max:1000'
            ]);

            if($validator->fails()) {
                Session::put('errors',$validator->errors()->all());
                return \view('message.error');
            }

            $this->position->position_title = $request->input('position_title');
            $this->position->position_description = str_limit($request->input('description'));
            $this->position->created_at = date('Y-m-d H:i:s');
            $this->position->created_by = Session::get('user')['user_id'];
            $this->position->updated_by = 0;

            if($this->position->save()) {
                Session::put('success','Successful Created Position');
                return response()->json(['redirect' => '/position']);
            }else {
                Session::put('errors',$validator->errors()->all());
                return \view('message.error');
            }
        }else {
            Session::put('errors', ['Method not allowed.']);
            return view('message/error');
        }
    }

    /**
     * open form Edit position
     *
     * @param Request $request
     * @return string
     */
    public function getEditPosition(Request $request) {
        $id = $request->input('id');
        $position = $this->position->where('id', '=', $id)->get()->first();
        return view('positions.edit')->with('position', $position)->render();
    }

    /**
     * Update position after open form
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request) {
        $positions = [
            'position_title' => $request->input('position_title'),
            'position_description' => $request->input('position_description'),
            'updated_at' => date('Y-m-d H:i:s'),
            'updated_by' => Session::get('user')['user_id'],
        ];

        $update = $this->position->find($request->input('id'))-> update($positions);
        if($update) {
            Session::put('success','Successful Update Position');
            return redirect('position');
        }
        return redirect('positions/edit');
    }

    /**
     * destroy position
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deletePosition(Request $request) {
        $id = $request->input('id');
        if ($this->position->where('id', '=', $id)->delete()) {
            return redirect('position');
        }
    }
}