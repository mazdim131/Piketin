<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_absensi_piket', 'status_kehadiran', 'tanggal_kehadiran'])]
class RiwayatPiket extends Model
{
    public function AbsensiPiket(): BelongsTo {
        return $this->belongsTo(AbsensiPiket::class, 'id_absensi_piket', 'id');
    }
}
