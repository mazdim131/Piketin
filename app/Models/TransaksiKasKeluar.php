<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nominal_masuk'])]
class TransaksiKasKeluar extends Model
{
    public function TotalKas(): HasMany {
        return $this->hasMany(TotalKas::class, 'id_transaksi_masuk', 'id');
    }
}
