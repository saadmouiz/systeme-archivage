<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdministratifRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'type' => 'required|string',
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];

        // Si c'est une création ou si un nouveau fichier est fourni
        if ($this->isMethod('post') || $this->hasFile('fichier')) {
            $rules['fichier'] = 'required|file|mimes:pdf,doc,docx|max:10240'; // 10MB max
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'type.required' => 'Le type de document est obligatoire',
            'titre.required' => 'Le titre est obligatoire',
            'titre.max' => 'Le titre ne doit pas dépasser 255 caractères',
            'fichier.required' => 'Le fichier est obligatoire',
            'fichier.mimes' => 'Le fichier doit être au format PDF, DOC ou DOCX',
            'fichier.max' => 'Le fichier ne doit pas dépasser 10MB'
        ];
    }
}