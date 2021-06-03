<?php

namespace App\Models\Transaction;

use App\Models\Master\Product;
use App\Models\Master\Team;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'team_id', 'date', 'amount'];
    protected $with = ['transaction_material', 'transaction_overhead'];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }

    public function transaction_material() {
        return $this->hasMany(ProductTransactionMaterial::class, 'product_transactions_id');
    }

    public function transaction_overhead() {
        return $this->hasMany(ProductTransactionOverhead::class, 'product_transactions_id');
    }
}
