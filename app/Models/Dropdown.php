<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropdown extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'subtype',
    ];

    public function stoMaps()
    {
        return $this->hasMany(Map::class, 'sto_id');
    }

    public function roomMaps()
    {
        return $this->hasMany(Map::class, 'room_id');
    }

    public function stoFirstDocs()
    {
        return $this->hasMany(Document::class, 'sto_first_id');
    }

    public function stoLastDocs()
    {
        return $this->hasMany(Document::class, 'sto_last_id');
    }

    public function typeDocs()
    {
        return $this->hasMany(Document::class, 'type_id');
    }

    // public function typeCore()
    // {
    //     return $this->hasMany(Core::class, 'type_id');
    // }

    public function cmeSto()
    {
        return $this->hasMany(Cme::class,'sto_id');
    }

    public function cmeType()
    {
        return $this->hasMany(Cme::class,'type_id');
    }

}
