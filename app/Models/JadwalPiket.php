<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['hari', 'jobdesk'])]

class JadwalPiket extends Model
{
    public function user(): HasMany {
        return $this->hasMany(User::class, 'id_jadwal_piket', 'id');
    }

    public function peringatan(): HasMany {
        return $this->hasMany(Peringatan::class, 'id_jadwal_piket', 'id');
    }
}
