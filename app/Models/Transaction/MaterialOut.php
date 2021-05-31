<?php

namespace App\Models\Transaction;

use App\Models\Master\Material;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialOut extends Model
{
    use HasFactory;
    protected $table = 'material_out';
    protected $fillable = ['material_id', 'date', 'amount', 'type', 'status', 'price'];

    public function material() {
        return $this->belongsTo(Material::class);
    }
}
