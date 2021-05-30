<?php

namespace App\Models\Transaction;

use App\Models\Master\Material;
use App\Models\Master\Supplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id', 'material_id', 'invoice', 'price', 'amount', 'type', 'date'];

    public function material() {
        return $this->belongsTo(Material::class);
    }

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }
}
