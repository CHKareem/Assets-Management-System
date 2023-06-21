<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'itemName',
        'arabicItemName',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function assetItems(){
        return $this->hasMany(Asset::class, 'item_id'); 
        
    }

    
}
