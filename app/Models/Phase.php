<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phase extends Model
{
    use HasFactory,  SoftDeletes;

    const PHASE_BACKLOG = 'Backlog';
    const PHASE_TODO = 'To Do';
    const PHASE_DOING = 'Doing';
    const PHASE_DONE = 'Done';
    const PHASE_ARCHIVED = 'Archived';

    protected $fillable = [
        'name',
    ];

    function tasks()
    {
        return $this->hasMany(Task::class);
    }

    
}
