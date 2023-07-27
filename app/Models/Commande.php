<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Commande extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference',
        'total',
        'status',
        'date',
    ];

    public function services()
    {
        return $this->belongsToMany(Service::class, 'service_commande')
                    ->withPivot('quantity');
    }

    use HasFactory;
}
