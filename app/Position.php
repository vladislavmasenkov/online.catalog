<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    public $table = 'positions';
    protected $fillable = ['name'];
    
    public function employees() {
        return $this->belongsTo('App\Employee','position','id');
    }
}
