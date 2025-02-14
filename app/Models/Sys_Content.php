<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sys_Content extends Model
{
    use HasFactory;

    protected $table = 'sys_content';
    protected $fillable = [        
        'id',
        'name',
        'value',
        'description',
        'url',
        'is_active',
        ];
}
