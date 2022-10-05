<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;
    protected $table = 'stok_opnames';

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id', 'id');
    }
}
