<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvenementMedia extends Model
{
    protected $table = 'evenement_media';  // Spécifiez explicitement le nom de la table

    protected $fillable = [
        'evenement_id',
        'type_media',
        'chemin_fichier',
        'titre',
        'description'
    ];

    public function evenement()
    {
        return $this->belongsTo(Evenement::class);
    }
}