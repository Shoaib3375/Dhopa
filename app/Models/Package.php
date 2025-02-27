<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'included_services'];

    protected $casts = [
        'included_services' => 'array', // Auto-convert JSON to array
    ];
}
