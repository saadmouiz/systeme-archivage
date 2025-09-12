<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArchiveRh extends Model
{
    use SoftDeletes;

    protected $table = 'archive_rh';

    protected $fillable = [
        'titre',
        'type',
        'employe_nom',
        'date_document',
        'statut',
        'description',
        'fichier'
    ];

    protected $casts = [
        'date_document' => 'date'
    ];

    public function getStatutColorAttribute()
    {
        return [
            'actif' => 'green',
            'archivé' => 'gray',
            'en cours' => 'blue',
            'terminé' => 'yellow'
        ][$this->statut] ?? 'gray';
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'Contrat' => 'document-text',
            'Fiche de paie' => 'currency-dollar',
            'Registre du personnel' => 'users',
            'Document de formation' => 'academic-cap',
            default => 'document'
        };
    }

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->date_document)) {
            $model->date_document = now()->toDateString();
        }
    });
}
}