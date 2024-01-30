<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
    'code',
    'subject_name',
    'sks',
    'semester',
    'program_study_id'
    ];
}


