<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overhead extends Model
{
    use HasFactory;
    protected $table = "m_overheads";
    protected $fillable = ['name', 'price', 'description', 'type'];
}
