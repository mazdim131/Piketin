<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['username', 'email', 'password', 'role', 'id_kelas', 'id_jadwal_piket', 'token'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'ms_user';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class, 'id_kelas', 'id');
    }

    public function JadwalPiket(): BelongsTo {
        return $this->belongsTo(JadwalPiket::class, 'id_jadwal_piket', 'id');
    }

    public function AbsensiPiket(): HasMany {
        return $this->hasMany(AbsensiPiket::class, 'username', 'username');
    }

    public function Peringatan(): HasMany {
        return $this->hasMany(Peringatan::class, 'username', 'username');
    }
}
