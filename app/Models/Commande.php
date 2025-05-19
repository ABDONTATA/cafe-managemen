<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Commande extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_id',
        'user_id',
        'status',
        'total_amount',
        'notes'
    ];

    /**
     * Get the table that the command belongs to.
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Get the user who created the command.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the line items for this command.
     */
    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
