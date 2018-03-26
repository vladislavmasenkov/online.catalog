<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $table = 'employees';

    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'position_id',
        'avatar',
        'employment_date',
        'director_id',
        'wage'
    ];

    public function position()
    {
        return $this->hasOne('App\Position', 'id', 'position_id');
    }

    public function employees()
    {
        return $this->hasMany('App\Employee', 'director_id', 'id');
    }

    public function director()
    {
        return $this->hasOne('App\Employee', 'id', 'director_id');
    }

    public static function getEmployeeById($id)
    {
        $employee = self::with('position')->with('director')->find($id);
        return $employee;
    }

    public static function getEmployeeWorkers(Employee $employee)
    {
        $workers = $employee->employees()->with('position')->with('director')->get();
        return $workers;
    }

    public static function getEmployeesWithoutDirector()
    {
        $employees = self::with('position')->where('director_id', NULL)->get();
        return $employees;
    }

    public static function getAllWithPagintaion($perPege = 20, $orderby = 'id', $order = 'asc', $filters = [])
    {
        $employees = self::with('position')->with('director');
        if ($orderby && \Schema::hasColumn('employees', $orderby)) {
            $employees->orderBy($orderby, $order);
        }
        if ($filters && is_array($filters)) {
            foreach ($filters as $filter) {
                $employees->where($filter['column'],'LIKE',$filter['query']);
            }
        }
        return $employees->paginate($perPege);
    }

    public static function getAllWithoutOne($withoutId,$perPage = 20) {
        $employees = self::with('position')->with('director')
            ->where('id','<>',$withoutId)->paginate($perPage);
        return $employees;
    }
}
