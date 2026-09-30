<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['id_transaksi_masuk', 'id_transaksi_keluar', 'jumlah_total_kas'])]
class TotalKas extends Model
{
    public function TransaksiKasMasuk(): BelongsTo {
        return $this->belongsTo(TransaksiKasMasuk::class, 'id_transaksi_masuk', 'id');
    }

    public function TransaksiKasKeluar(): BelongsTo {
        return $this->belongsTo(TransaksiKasKeluar::class, 'id_transaksi_keluar', 'id');
    }
}
