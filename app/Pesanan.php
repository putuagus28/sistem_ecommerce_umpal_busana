<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;
    protected $table = 'pesanans';

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'users_global', 'id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'users_global', 'id');
    }

    public function detail()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanans_id', 'id');
    }
}
