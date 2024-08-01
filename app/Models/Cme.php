<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cme extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'sto_id',
        'underfive',
        'morethanfive',
        'morethanten',
        'type_id',
        
    ];

    public function cmeSto()
    {
        return $this->belongsTo(Dropdown::class, 'sto_id');
    }


    public function cmeType()
    {
        return $this->belongsTo(Dropdown::class, 'type_id');
    }
    
}

