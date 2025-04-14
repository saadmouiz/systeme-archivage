<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administratif extends Model
{
    use HasFactory;
    protected $fillable = 
    ['type', 
    'titre', 
    'description',
    'fichier'];

}
