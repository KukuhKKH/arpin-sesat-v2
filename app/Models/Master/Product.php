<?php

namespace App\Models\Master;

use App\Models\Transaction\ProductSelling;
use App\Models\Transaction\ProductTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'm_product';
    protected $fillable = ['code', 'name', 'unit', 'price', 'total'];

    public function product_transaction() {
        return $this->hasMany(ProductTransaction::class);
    }

    public function product_selling() {
        return $this->hasMany(ProductSelling::class);
    }
}
