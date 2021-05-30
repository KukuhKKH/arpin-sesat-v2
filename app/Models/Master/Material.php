<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;
    protected $table = "m_materials";
    protected $fillable = ['code', 'name', 'unit', 'price', 'total', 'type'];
}
