<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['id_user', 'status'])]
class AbsensiPiket extends Model
{
    protected $table = 'tr_absensi_piket';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function riwayatPiket(): HasMany
    {
        return $this->hasMany(RiwayatPiket::class, 'id_absensi_piket', 'id');
    }
}
