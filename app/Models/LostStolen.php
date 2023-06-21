<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LostStolen extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'asset_alter_id',
        'documentNumber',
        'lostDate',
        'isStolen',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function assets(){
        return $this->belongsTo(Asset::class, 'asset_id'); 
        
    }

    public function alters(){
        return $this->belongsTo(Asset::class, 'asset_alter_id'); 
        
    }

    public function getIsStolenNameAttribute($value)
    {
        switch ($this->attributes['isStolen']) {
            case 1: // here is number not string.
                return 'Yes';
            case 0:
                return 'No';
        }
    }

}
