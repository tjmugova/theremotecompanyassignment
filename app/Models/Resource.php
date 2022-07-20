<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $casts = [
        'open_in_new_tab' => 'boolean',
        'created_at' => 'datetime:Y-m-d',
    ];
}
