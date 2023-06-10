<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory, UuidTrait;

    const STATUS_ACTIVE = 'ACTIVE';
    const STATUS_CHECKED_IN = 'CHECKED_IN';
    const STATUS_CANCELLED = 'CANCELLED';

    const MAX_SEATING = 32;

    protected $fillable = [
        'flight_id',
        'passport_id',
        'seat',
        'status',
    ];

    protected $visible = [
        'uuid',
        'status',
        'seat',
        'passport_id',
        'flight',
    ];

    protected $attributes = [
        'status' => self::STATUS_ACTIVE,
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($ticket) {
            $ticket->seat = rand(1, self::MAX_SEATING);
        });
    }

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }
}
