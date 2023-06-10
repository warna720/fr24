<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory, UuidTrait;

    protected $visible = [
        'uuid',
        'departure_at',
        'source',
        'destination',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
