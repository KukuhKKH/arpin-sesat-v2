<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = "m_employees";
    protected $fillable = ['team_id', 'name'];

    public function team() {
        return $this->belongsTo(Team::class);
    }
}
