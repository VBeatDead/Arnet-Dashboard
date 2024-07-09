<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DenahSto extends Model
{
    protected $table = 'denah_sto';

    protected $fillable = [
        'lokasi_sto',
        'denah'
    ];
}
