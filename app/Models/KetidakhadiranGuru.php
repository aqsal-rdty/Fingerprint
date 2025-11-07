<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KetidakhadiranGuru extends Model
{
    use HasFactory;

    protected $table = 'ketidakhadiranguru';
    protected $primaryKey = 'id_ketidakhadiran';

    protected $fillable = [
        'nip',
        'tanggal',
        'ket',
    ];

    public $timestamps = true;
}