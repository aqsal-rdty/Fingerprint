<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;
    
    protected $table = 'rombel' ;
    protected $primaryKey = 'id_rombel';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = true ;

    protected $fillable = [
        'id_rombel',
        'nama_rombel',
        'id_jurusan',
    ];

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }
}
