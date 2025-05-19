<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Facture extends Model
{
    protected $fillable = ['commande_id', 'total', 'date_paiement', 'mode_paiement'];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }
}
