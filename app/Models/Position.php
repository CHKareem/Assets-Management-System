<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    protected $connection ='mysql2';
    
    public function transportPositions(){
        return $this->hasMany(Transport::class, 'position_id'); 
        
    }

}
