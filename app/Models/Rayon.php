<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rayon extends Model
{
    use HasFactory;

    protected $table = 'rayon';
    protected $primaryKey = 'id_rayon';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

   protected $fillable = [
        'id_rayon',
        'nama_rayon',
        'pembimbing_id',
        'nomor_ruangan',
    ];

    public function pembimbing()
    {
        return $this->belongsTo(Guru::class, 'pembimbing_id', 'nip');
    }
}
