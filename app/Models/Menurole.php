<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menurole extends Model
{
    use HasFactory;
    
    protected $table = 'tx_menu_roles';

    protected $fillable = [
        'menu_id',
        'role_id',
        'description',
        'is_active'
    ];
}
