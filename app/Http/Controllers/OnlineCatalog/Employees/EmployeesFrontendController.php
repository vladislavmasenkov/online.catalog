<?php

namespace App\Http\Controllers\OnlineCatalog\Employees;

use App\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmployeesFrontendController extends Controller
{
    public function index()
    {
        $employees = Employee::with('position')
            ->where('director_id',null)->get();
        foreach ($employees as $key => $employee) {
            $employees[$key]->workers = Employee::getEmployeeWorkers($employees[$key]);
        }

        return view('onlinecatalog.employees.frontend.index',[
            'employees' => $employees
        ]);
    }

    public function card($id) {
        $employee = Employee::getEmployeeById($id);
        return view('onlinecatalog.employees.frontend.card', [
           'employee' => $employee
        ]);
    }

    public function workers($id) {
        $employee = Employee::getEmployeeById($id);
        $workers = Employee::getEmployeeWorkers($employee);
        return view('onlinecatalog.employees.frontend.workers',[
            'employee' => $employee,
            'workers' => $workers
        ]);
    }
}
