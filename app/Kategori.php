<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    use \App\Traits\TraitUuid;
    protected $table = 'kategoris';

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
