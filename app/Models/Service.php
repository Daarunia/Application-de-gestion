<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'reference',
        'price'
    ];

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'service_commande')
                    ->withPivot('quantity');
    }

    use HasFactory;
}
