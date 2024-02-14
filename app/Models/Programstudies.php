<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programstudies extends Model
{
    use HasFactory;

    protected $table = 'program_studies';

    protected $fillable = [
        'prodi_name',
        'description'
    ];
}
