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
        'position',
        'avatar',
        'employment_date',
        'director',
        ];

    public function position() {
        return $this->hasOne('App\Position','id','position');
    }
}
