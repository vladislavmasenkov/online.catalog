<?php

namespace App\Http\Controllers\OnlineCatalog\Employees;

use App\Http\Requests\OnlineCatalog\Employees\EmployeeValidator;
use App\Position;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;
use Illuminate\Support\Facades\Input;
class EmployeesResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orderby = $request->input('orderby');
        $order = ($request->get('order') == 'asc') ? 'asc' : 'desc';
        $filters = json_decode($request->input('filters'),true);


        $employees = Employee::getAllWithPagintaion(20, $orderby, $order, $filters);

        if ($request->ajax()) {
            return view('onlinecatalog.employees.resource.ajaxlist', [
                'employees' => $employees,
            ])->render();
        }
        return view('onlinecatalog.employees.resource.index', [
            'employees' => $employees->appends(request()->only(['page'])),
            'order' => $order,
            'orderby' => $orderby,
            'filter' => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $positions = Position::all();
        if (request()->ajax()) {
            return view('onlinecatalog.employees.resource.ajaxcreate', [
                'positions' => $positions
            ])->render();
        }
        return view('onlinecatalog.employees.resource.create', [
            'positions' => $positions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeValidator $request)
    {
        $employee = new Employee();
        $employee->fill([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'middle_name' => $request->input('middle_name'),
            'position_id' => $request->input('position_id'),
            'wage' => $request->input('wage'),
            'employment_date' => $request->input('employment_date'),
            'director_id' => ($request->input('director_id')) ? $request->input('director_id') : NULL,
            'avatar' => Employee::uploadEmployeeImg($request->file('avatar'))
        ]);
        $employee->save();
        return response()->json([
            'success' => true,
            'message' => \Lang::get('messages.SuccessEmployeeStore')
        ],400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::getEmployeeById($id);
        return view('onlinecatalog.employees.resource.show', [
            'employee' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::getEmployeeById($id);
        $positions = Position::where('id', '<>', $employee->position->id)->get();
        if (request()->ajax()) {
            return view('onlinecatalog.employees.resource.ajaxedit', [
                'employee' => $employee,
                'positions' => $positions
            ])->render();
        }
        return view('onlinecatalog.employees.resource.edit', [
            'employee' => $employee,
            'positions' => $positions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeValidator $request, $id)
    {
        $employee = Employee::find($id);
        if ($employee) {
            $employee->fill([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'middle_name' => $request->input('middle_name'),
                'position_id' => $request->input('position_id'),
                'wage' => $request->input('wage'),
                'employment_date' => $request->input('employment_date'),
                'director_id' => ($request->input('director_id')) ? $request->input('director_id') : NULL,
                'avatar' => Employee::uploadEmployeeImg($request->file('avatar'))
            ]);
            $employee->save();
            return response()->json([
                'success' => true,
                'message' => \Lang::get('messages.SuccessEmployeeUpdate')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => \Lang::get('messages.FailEmployeeUpdate')
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::getEmployeeById($id);
        if ($employee) {
            Employee::destroy([$id]);
            return response()->json([
                'success' => true,
                'message' => \Lang::get('messages.SuccessEmployeeDestroy')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => \Lang::get('messages.FailEmployeeDestroy')
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyMany(Request $request) {
        $ids = explode(',',$request->input('ids'));
        if($ids && $request->input('ids')) {
            Employee::destroy($ids);
            return response()->json([
                'success' => true,
                'message' => \Lang::get('messages.SuccessEmployeeDestroyMany')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => \Lang::get('messages.FailEmployeeDestroyMany')
        ],400);
    }

    public function getDirectors(Request $request,$id) {
        $directors = Employee::getPossibleDirectors($id,7);
        if(request()->ajax()) {
            return view('onlinecatalog.employees.resource.directors',[
                'employees' => $directors
            ])->render();
        }
        return view('onlinecatalog.employees.resource.directors',[
            'employees' => $directors
        ]);
    }

    public function updateDirector(Request $request,$id) {
        $this->validate($request,[
            'director_id' => 'integer|required'
        ]);

        $employee = Employee::find($id);
        if($employee) {
            $employee->director_id = $request->input('director_id');
            $employee->save();
            return response()->json([
                'success' => true,
                'message' => \Lang::get('messages.SuccessUpdateDirector')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => \Lang::get('messages.FailUpdateDirector')
        ],400);
    }
}
