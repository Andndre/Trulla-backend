<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'checklist_id',
        'name',
        'is_completed'
    ];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }
}
