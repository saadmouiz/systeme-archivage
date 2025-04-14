<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LegalDocument extends Model
{
    protected $fillable = [
        'type', 'title', 'description', 'date_emission', 'date_expiration',
        'reference_number', 'status', 'notes',
    ];



    protected $casts = [
        'date_emission' => 'date',
        'date_expiration' => 'date'
    ];

    // Relation avec les fichiers
    public function files()
    {
        return $this->hasMany(LegalDocumentFile::class);
    }

    // Accesseur pour le statut du document
    public function getStatusBadgeClassAttribute()
    {
        return match($this->status) {
            'actif' => 'bg-green-100 text-green-800',
            'expire' => 'bg-red-100 text-red-800',
            'en_cours' => 'bg-yellow-100 text-yellow-800',
            'resolu' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Accesseur pour vérifier si le document est expiré
    public function getIsExpiredAttribute()
    {
        if (!$this->date_expiration) return false;
        return $this->date_expiration->isPast();
    }
}