<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;
    protected $table = 'carts';

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produks_id', 'id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'users_global', 'id');
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'users_global', 'id');
    }
}
