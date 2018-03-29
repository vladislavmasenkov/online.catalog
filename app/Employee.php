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

    public static function boot()
    {
        parent::boot();

        Employee::deleting(function ($employee) {
            $workers = Employee::getEmployeeWorkers($employee);
            $colleague = Employee::getColleague($employee);
            if ($colleague && $workers) {
                foreach ($workers as $worker) {
                    $worker->director()->associate($colleague)->save();
                }
            } else {
                foreach ($workers as $worker) {
                    $worker->director()->dissociate()->save();
                }
            }
        });
    }

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
        return $this->belongsTo('App\Employee', 'director_id', 'id');
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
            foreach ($filters as $name => $filter) {
                if (isset($filter['field']) && !empty($filter['field'])) {
                    $employees->whereHas($name, function ($query) use ($filter) {
                        foreach ($filter['queries'] as $k => $words) {
                            $query->where($filter['field'], 'LIKE', "%{$words}%");
                        }
                    });
                } else {
                    foreach ($filter['queries'] as $words) {
                        $employees->where($name, 'LIKE', "%{$words}%");
                    }
                }
            }
        }
        return $employees->paginate($perPege);
    }

    public static function getPossibleDirectors($id = 0, $perPage = 20)
    {
        $employees = self::with('position')->with('director')
            ->where('id', '<>', $id)
            ->where('director_id','<>',$id)
            ->paginate($perPage);
        return $employees;
    }

    public static function getColleagues(Employee $employee)
    {
        $colleagues = Employee::where('position_id', $employee->position_id)
            ->where('id', '<>', $employee->id)->get();
        return $colleagues;
    }

    public static function getColleague(Employee $employee)
    {
        $colleagues = Employee::where('position_id', $employee->position_id)
            ->where('id', '<>', $employee->id)->first();
        return $colleagues;
    }

    public static function uploadEmployeeImg($avatar)
    {
        if (is_file($avatar)) {
            $filename = uniqid('employee_avatar_') . '.jpeg';
            \File::put(public_path('images/onlinecatalog/employees/' . $filename), \File::get($avatar));
            return (file_exists(public_path('images/onlinecatalog/employees/' . $filename))) ? $filename : NULL;
        }
        return NULL;
    }
}
