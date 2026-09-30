<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['username', 'id_jadwal_piket', 'status_peringatan', 'tanggal_peringatan'])]
class Peringatan extends Model
{
    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function jadwalPiket(): BelongsTo {
        return $this->belongsTo(JadwalPiket::class, 'id_jadwal_piket', 'id');
    }
}
