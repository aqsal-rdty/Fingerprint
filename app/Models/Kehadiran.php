<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    protected $table = "kehadiran";
	protected $primarykey= "id_kehadiran";
	public $incrementing = true;
	public $timestamps = true;
    protected $fillable = [
        'id_kehadiran',
        'nis',
        'tanggal',
        'waktu',
        'ket',
        'machine_id',
        'status',
    ];
}
