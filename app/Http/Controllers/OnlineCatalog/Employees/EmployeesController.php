<?php

namespace App\Http\Controllers\OnlineCatalog\Employees;

use App\Http\Requests\OnlineCatalog\Employees\EmployeeValidator;
use App\Position;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Employee;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::find(2);
        $positions = Position::all()->where('id','<>',$employee->position);
        dump([$employee->toArray(),$positions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeValidator $request)
    {


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id)->toArray();
        return view('employees.show',['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employee = Employee::find($id)->with('position');
        $positions = Position::all()->where('id','!=',$employee->position->id);
        dump([$employee,$positions]);
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
                'midlle_name' => $request->input('midlle_name'),
                'position' => $request->input('position'),
                'avatar' => $request->input('avatar'),
                'employment_date' => $request->input('employment_date'),
                'director' => $request->input('director'),
            ]);
            $employee->save();
            return response()->json([
                'success' => true,
                'message' => \Lang::get('SuccessEmployeeUpdate')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => \Lang::get('FailEmployeeUpdate')
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
                'message' => \Lang::get('SuccessEmployeeDestroy')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => \Lang::get('FailEmployeeDestroy')
        ]);
    }
}
