<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KehadiranGuru extends Model
{
    use HasFactory;

    protected $table = 'kehadiranguru';
    protected $primaryKey = 'id_kehadiran';

    protected $fillable = [
        'nip',
        'tanggal',
        'waktu',
        'status',
    ];

    public $timestamps = true;

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'nip', 'nip');
    }
}