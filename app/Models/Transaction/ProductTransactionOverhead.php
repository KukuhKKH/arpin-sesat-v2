<?php

namespace App\Models\Transaction;

use App\Models\Master\Overhead;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransactionOverhead extends Model
{
    use HasFactory;
    protected $fillable = ['product_transactions_id', 'overhead_id'];
    protected $with = ['overhead'];

    public function product_transaction() {
        return $this->belongsTo(ProductTransaction::class, 'product_transactions_id', 'id');
    }

    public function overhead() {
        return $this->belongsTo(Overhead::class);
    }
}
