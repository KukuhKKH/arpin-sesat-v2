<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coa extends Model
{
    use HasFactory;
    protected $table = "m_coa";
    protected $fillable = ['code', 'name', 'balance', 'active'];
}
