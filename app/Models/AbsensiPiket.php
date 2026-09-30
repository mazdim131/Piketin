<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['username', 'password'])]
class AbsensiPiket extends Model
{
    public function user():BelongsTo {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function riwayatPiket(): HasMany {
        return $this->hasMany(RiwayatPiket::class, 'id_absensi_piket', 'id');
    }
}
