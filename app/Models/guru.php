<?php

namespace App\Models;

use App\QwKehadiranGuru;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\FuncCall;

class Guru extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'guru';
    protected $primaryKey = 'nip';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nip', 
        'nama', 
        'status'
    ];

    public function kehadiran() {
        return $this->hasMany(KehadiranGuru::class, 'nip', 'nip');
    }

    public function kehadiranguru() {
        return $this->hasMany(KehadiranGuru::class, 'nip', 'nip');
    }

    public function keterlambatan() {
        return $this->hasMany(Keterlambatan::class, 'nip', 'nip');
    }
}