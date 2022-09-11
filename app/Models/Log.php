<?php

namespace App\Models;

use App\Casts\JsonCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'uri',
        'user_agent',
        'request',
        'response',
    ];

    protected $hidden = [
        'updated_at',
    ];

    protected $casts = [
        'request' => JsonCast::class,
        'response' => JsonCast::class,
    ];
}
