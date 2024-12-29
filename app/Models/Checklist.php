<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'judul',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function subChecklists()
    {
        return $this->hasMany(SubChecklist::class);
    }
}
