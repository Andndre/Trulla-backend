<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // fillable
    protected $fillable = [
        'judul',
        'deskripsi',
        'team_id',
        'user_id',
        'status',
        'deadline'
    ];

    // relations
    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function checklists()
    {
        return $this->hasMany(Checklist::class);
    }

    public function notes()
    {
        return $this->hasMany(Note::class);
    }
}
