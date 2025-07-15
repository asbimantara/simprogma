<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'progja_id',
        'jenis',
        'keterangan',
        'nama_file',
        'path_file',
        'uploaded_at',
    ];

    public function progja()
    {
        return $this->belongsTo(Progja::class);
    }
} 