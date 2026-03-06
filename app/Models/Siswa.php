<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswa';
    protected $primaryKey = 'id_siswa';

    public function mst_provinsi()
    {
        return $this->belongsTo('App\Models\Provinsi','provinsi_id');
    }

    public function mst_kabupaten()
    {
        return $this->belongsTo('App\Models\Kabupaten','kabupaten_id');
    }

    public function mst_kecamatan()
    {
        return $this->belongsTo('App\Models\Kecamatan','kecamatan_id');
    }

    public function mst_desa()
    {
        return $this->belongsTo('App\Models\Desa','desa_id');
    }

    public function transaksi(){
        return $this->hasMany('App\Http\Models\Transaksi', 'id_siswa');
    }
}
