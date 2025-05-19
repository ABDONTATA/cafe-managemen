<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // لازم تزيد هادي إذا بغيت تعمر الدور جماعياً
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Check if the user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user is a waiter
     */
    public function isWaiter(): bool
    {
        return $this->role === 'serveur';
    }

    /**
     * Get the dashboard route for this user
     */
    public function getDashboardRoute(): string
    {
        return $this->isAdmin() ? 'admin.dashboard' : 'serveur.dashboard';
    }

    // العلاقة مع الطلبات
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
