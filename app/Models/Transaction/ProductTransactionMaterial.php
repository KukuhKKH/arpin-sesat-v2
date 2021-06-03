<?php

namespace App\Models\Transaction;

use App\Models\Master\Material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransactionMaterial extends Model
{
    use HasFactory;
    protected $fillable = ['product_transactions_id', 'material_id', 'amount'];
    protected $with = ['material'];

    public function product_transaction() {
        return $this->belongsTo(ProductTransaction::class, 'product_transactions_id', 'id');
    }

    public function material() {
        return $this->belongsTo(Material::class);
    }
}
