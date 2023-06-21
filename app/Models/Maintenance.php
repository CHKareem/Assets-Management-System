<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'asset_id',
        'sendDate',
        'receiveDate',
        'statusAfter',
        'statusBefore',
        'isPaid',
        'whereMaintained',
        'documentType',
        'documentNumber',
        'technicalDisclosureNumber',
        'paymentPrice',
        'reason',
        'notes',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function assets(){
        return $this->belongsTo(Asset::class, 'asset_id'); 
        
    }

    public function getIsPaidNameAttribute($value)
    {
        switch ($this->attributes['isPaid']) {
            case 1: // here is number not string.
                return 'Yes';
            case 0:
                return 'No';
        }
    }

    public function getWhereMaintainedNameAttribute($value)
    {
        switch ($this->attributes['whereMaintained']) {
            case 1: // here is number not string.
                return 'External';
            case 0:
                return 'Internal';
        }
    }

}
