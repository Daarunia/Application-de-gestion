<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_commande')
                    ->withPivot('quantity');
    }

    use HasFactory;
}
