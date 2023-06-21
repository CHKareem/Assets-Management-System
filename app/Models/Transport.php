<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'center_id',
        'department_id',
        'employee_id',
        'employee_prev_id',
        'position_id',
        'transportDate',
        'documentType',
        'documentNumber',
        'isHanded',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function assets(){
        return $this->belongsTo(Asset::class, 'asset_id'); 
        
    }

    public function centers(){
        return $this->belongsTo(Center::class, 'center_id'); 
        
    }

    public function departments(){
        return $this->belongsTo(Department::class, 'department_id'); 
        
    }

    public function positions(){
        return $this->belongsTo(Position::class, 'position_id'); 
        
    }

    public function employees(){
        return $this->belongsTo(Employee::class, 'employee_id'); 
        
    }

    public function prevs(){
        return $this->belongsTo(Employee::class, 'employee_prev_id'); 
        
    }


    public function getIsHandedNameAttribute($value)
    {
        switch ($this->attributes['isHanded']) {
            case 1: // here is number not string.
                return 'Yes';
            case 0:
                return 'No';
        }
    }

}
