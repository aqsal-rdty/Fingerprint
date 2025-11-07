<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerprintGuru extends Model
{
    protected $table = "fingerprint_machines_guru";
    protected $primaryKey = "id";
    public $incrementing = true;
    public $timestamps = true;
    protected $fillable = [
        'id',
        'ip',
        'comkey',
        'status',
    ];
}
