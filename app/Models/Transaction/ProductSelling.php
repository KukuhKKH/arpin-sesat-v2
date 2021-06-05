<?php

namespace App\Models\Transaction;

use App\Models\Master\Customer;
use App\Models\Master\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSelling extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'product_id', 'amount', 'date'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function product() {
        return $this->belongsTo(Product::class);
    }
}
