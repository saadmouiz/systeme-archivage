<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Communication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'titre',
        'description',
        'date_publication',
        'fichier',
        'format_type',
        'metadata'
    ];

    protected $casts = [
        'date_publication' => 'date',
        'metadata' => 'array'
    ];

    // Accesseur pour obtenir l'URL complète du fichier
    public function getFichierUrlAttribute()
    {
        return asset('storage/' . $this->fichier);
    }

    // Accesseur pour obtenir l'icône en fonction du format
    public function getFormatIconAttribute()
    {
        return match($this->format_type) {
            'video' => 'video-camera',
            'image' => 'camera',
            'article' => 'document-text',
            'pdf' => 'document',
            default => 'document'
        };
    }
}