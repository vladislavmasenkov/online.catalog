<?php

namespace App\Http\Controllers\OnlineCatalog\Employees;

use App\Http\Requests\OnlineCatalog\Employees\EmployeeValidator;
use App\Position;
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
        $order = ($request->get('order') == 'asc')?'asc':'desc';
        $filters = $request->get('filters');

        $employees = Employee::getAllWithPagintaion(20,$orderby,$order,$filters);

        if($request->ajax()) {
            return view('onlinecatalog.employees.resource.ajaxlist',[
                'employees' => $employees,
            ])->render();
        }
        return view('onlinecatalog.employees.resource.index',[
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
        if(request()->ajax()) {
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
            'avatar' => $request->input('avatar'),
            'wage' => $request->input('wage'),
            'employment_date' => $request->input('employment_date'),
            'director_id' => ($request->input('director_id'))?$request->input('director_id'):NULL
        ]);
        $employee->save();
        return response()->json([
            'success' => true,
            'message' => \Lang::get('messages.SuccessEmployeeStore')
        ]);
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
        $positions = Position::where('id','<>',$employee->position->id)->get();
        if(request()->ajax()) {
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
        if($employee) {
            $employee->fill([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'middle_name' => $request->input('middle_name'),
                'position_id' => $request->input('position_id'),
                'avatar' => $request->input('avatar'),
                'wage' => $request->input('wage'),
                'employment_date' => $request->input('employment_date'),
                'director_id' => ($request->input('director_id'))?$request->input('director_id'):NULL
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
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Employee::find($id)) {
            Employee::destroy([$id]);
            return response()->json([
                'success' => true,
                'message' => \Lang::get('messages.SuccessEmployeeDestroy')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => \Lang::get('messages.FailEmployeeDestroy')
        ]);
    }
}
