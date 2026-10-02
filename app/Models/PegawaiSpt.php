<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class PegawaiSpt extends Model { protected $guarded = ['id']; public function pegawai() { return $this->belongsTo(Pegawai::class); } }
