<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'typeName',
        'arabicTypeName',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function assetTypes(){
        return $this->hasMany(Asset::class, 'type_id'); 
        
    }

}
