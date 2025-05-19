<?php



namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
{
    public function authorize()
    {
        
        return true;
    }

    public function rules()
    { 
        $tableId = $this->route('table')?->id ?? null;

        return [
            'numero' => 'required|string|unique:tables,numero,' . $tableId,
            'statut' => 'required|in:libre,occupée,réservée',
            'capacite' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'numero.required' => 'le numéro de la table est necessaire.',
            'numero.unique' => 'le numéro de la table doit être unique.',
            'statut.required' => 'la statut de la table est necessaire.',
            'statut.in' => 'etat doit etre :libre, occupée, réservée.',
            'capacite.required' => 'la capacité de la table est necessaire.',
            'capacite.integer' => 'la capacité doit être un nombre entier.',
            'capacite.min' => 'la capacité doit être au moins 1.',
        ];
    }
}
