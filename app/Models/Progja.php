<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progja extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_progja',
        'tanggal_pelaksanaan',
        'sasaran',
        'hasil',
        'indikator',
        'penanggung_jawab',
        'kategori',
        'anggaran',
        'status_id',
        'user_id',
        'keterangan_revisi',
        'keterangan_revisi_lpj',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
