<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'nama',
        'pemilik',
        'icon_path',
    ];

    // relations
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
