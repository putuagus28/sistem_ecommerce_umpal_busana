<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;
    protected $table = 'detail_pesanans';

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id', 'id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanans_id', 'id');
    }
}
