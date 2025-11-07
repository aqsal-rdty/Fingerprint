<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerprintMachine extends Model
{
    protected $table = "fingerprint_machines";
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
