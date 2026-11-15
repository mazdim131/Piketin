<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

#[Fillable(['name', 'admin_id', 'token', 'is_active'])]
class Room extends Model
{
    protected $table = 'ms_room';

    public function getRouteKeyName(): string
    {
        return 'token';
    }

    protected static function booted(): void
    {
        static::creating(function (Room $room): void {
            if (empty($room->token)) {
                do {
                    $token = strtoupper(Str::random(6));
                } while (self::where('token', $token)->exists());

                $room->token = $token;
            }
        });
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(User::class, 'room_id');
    }
}
