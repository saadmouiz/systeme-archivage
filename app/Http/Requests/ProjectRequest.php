<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:en cours,planifiée,términée',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'responsable' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Le titre est obligatoire',
            'description.required' => 'La description est obligatoire',
            'status.required' => 'Le statut est obligatoire',
            'status.in' => 'Le statut doit être: en cours, planifiée ou términée',
            'end_date.after_or_equal' => 'La date de fin doit être après la date de début',
            'budget.numeric' => 'Le budget doit être un nombre',
            'budget.min' => 'Le budget ne peut pas être négatif'
        ];
    }
}