<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ketidakhadiran extends Model
{
    protected $table = "ketidakhadiran";
	protected $primarykey= "id_ketidakhadiran";
	public $incrementing = false;
	public $timestamps = false;
    protected $fillable = [
        'id_ketidakhadiran',
        'nis',
        'tanggal',
        'keterangan',
    ];
}