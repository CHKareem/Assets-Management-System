<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $connection ='mysql2';

    public function transportEmployees(){
        return $this->hasMany(Transport::class, 'employee_id'); 
        
    }

    public function transportPrevEmployees(){
        return $this->hasMany(Transport::class, 'employee_prev_id'); 
        
    }

}
