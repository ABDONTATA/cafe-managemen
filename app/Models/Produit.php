<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    protected $fillable = ['nom', 'prix', 'categorie_id', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}