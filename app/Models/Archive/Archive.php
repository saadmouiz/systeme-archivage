<?php

namespace App\Models\Archive;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'category',
        'sub_category',
        'files',
    ];
    
    /**
     * Les attributs qui doivent être convertis.
     *
     * @var array
     */
    protected $casts = [
        'files' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}