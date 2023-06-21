<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'type_id',
        'center_id',
        'department_id',
        'codeNamaa',
        'status',
        'quantity',
        'realPrice',
        'expectedPrice',
        'serialNumber',
        'aquisitionDate',
        'aquisitionType',
        'fundedBy',
        'documentNumber',
        'notes',
        'inService',
        'description',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function transportAssets(){
        return $this->hasMany(Transport::class, 'asset_id'); 
        
    }

    public function mainteneanceAssets(){
        return $this->hasMany(Maintenance::class, 'asset_id'); 
        
    }

    public function lostAssets(){
        return $this->hasMany(LostStolen::class, 'asset_id'); 
        
    }

    public function lostAlterAssets(){
        return $this->hasMany(LostStolen::class, 'asset_alter_id'); 
        
    }

    public function items(){
        return $this->belongsTo(Item::class, 'item_id'); 
        
    }

    public function types(){
        return $this->belongsTo(Type::class, 'type_id'); 
        
    }

    public function getInServiceNameAttribute($value)
    {
        switch ($this->attributes['inService']) {
            case 1: // here is number not string.
                return 'In Service';
            case 0:
                return 'Not In Service';
        }
    }

}
