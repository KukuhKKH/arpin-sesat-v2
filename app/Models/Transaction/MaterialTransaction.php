<?php

namespace App\Models\Transaction;

use App\Models\Master\Material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialTransaction extends Model
{
    use HasFactory;
    protected $fillable = ['material_id', 'price', 'amount', 'type', 'date'];

    public function material() {
        return $this->belongsTo(Material::class);
    }
}
