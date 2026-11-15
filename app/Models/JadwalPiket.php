<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_user', 'day', 'jobdesk'])]

class JadwalPiket extends Model
{
    protected $table = 'ms_jadwal_piket';

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function peringatan(): HasMany
    {
        return $this->hasMany(Peringatan::class, 'id_jadwal_piket', 'id');
    }
}
