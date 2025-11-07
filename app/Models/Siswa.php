<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'nis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nis',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jk',
        'alamat',
        'id_rayon',
        'id_rombel',
        'id_jurusan',
    ];

    public function rayon()
    {
        return $this->belongsTo(Rayon::class, 'id_rayon', 'id_rayon');
    }

    public function rombel()
    {
        return $this->belongsTo(Rombel::class, 'id_rombel', 'id_rombel');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }
}