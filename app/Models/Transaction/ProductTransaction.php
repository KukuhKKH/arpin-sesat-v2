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

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function team() {
        return $this->belongsTo(Team::class);
    }
}
