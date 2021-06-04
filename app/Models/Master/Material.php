<?php

namespace App\Models\Master;

use App\Models\Transaction\MaterialOut;
use App\Models\Transaction\MaterialTransaction;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = "m_materials";
    protected $fillable = ['code', 'name', 'unit', 'price', 'total', 'type'];

    public function transaction() {
        return $this->hasMany(MaterialTransaction::class);
    }

    public function out() {
        return $this->hasMany(MaterialOut::class);
    }
}
