<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;
    protected $table = 'specialization'; 
    protected $fillable = [
        'specialization_title',
    ];

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }
}
