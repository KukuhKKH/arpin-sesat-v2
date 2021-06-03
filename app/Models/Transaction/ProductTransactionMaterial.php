<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransactionMaterial extends Model
{
    use HasFactory;
    protected $fillable = ['product_transactions_id', 'material_id', 'amount'];
}
