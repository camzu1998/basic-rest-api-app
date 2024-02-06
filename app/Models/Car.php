<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    const DEFAULT_TYPES = ['small', 'big'];

    protected $fillable = [
        'name',
        'type'
    ];

    public function scopeType($query, $type)
    {
        $query->where('type', $type);
    }
}
