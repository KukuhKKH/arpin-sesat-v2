<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransactionOverhead extends Model
{
    use HasFactory;
    protected $fillable = ['product_transactions_id', 'overhead_id'];
}
