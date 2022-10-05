<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;
    protected $table = 'produks';

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategoris_id', 'id');
    }

    public function terjual()
    {
        return $this->hasMany(DetailPesanan::class, 'produks_id', 'id');
    }
}
