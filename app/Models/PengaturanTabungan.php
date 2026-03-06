<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaturanTabungan extends Model
{
    use HasFactory;

    protected $table = 'pengaturan_tabungan';
    protected $primaryKey = 'id_pengaturan_tabungan';
    protected $fillable = ['nominal_tabungan_pertama', 'minimum_setor_debet', 'minimum_saldo'];
}
