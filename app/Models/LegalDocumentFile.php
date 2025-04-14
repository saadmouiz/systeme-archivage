<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocumentFile extends Model
{
    protected $fillable = [
        'legal_document_id',
        'filename',
        'file_path',
        'file_type',
        'description'
    ];

    public function document()
    {
        return $this->belongsTo(LegalDocument::class, 'legal_document_id');
    }

    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}