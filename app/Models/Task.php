<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'name',
        'phase_id',
        'user_id',
        'completed_at'
    ];

   


    use HasFactory;

    function user()
    {
        return $this->belongsTo(User::class);
    }

    function phase()
    {
        return $this->belongsTo(Phase::class);
    }

    function scopeMarkCompleted($query,  $phase_id)
    {
       $query->update(['phase_id' => $phase_id]);
    }

    
    protected static function boot()
    {
        parent::boot();
        static::updating(function($task) {
            if(($task->phase_id != $task->getOriginal('phase_id')) && (!$task->getOriginal('completed_at')))
            {
                $phase = Phase::find($task->phase_id);
                if($phase->name === Phase::PHASE_DONE)
                {
                    $task->completed_at = now();
                }
            }
            
        });
    }


    // public function setCompletedAtAttribute()
    // {
    //     dd($this->attributes['phase_id']);
    //     $completion_phase = [Phase::PHASE_DONE,Phase::PHASE_ARCHIVED];
    //     // $phase_id = 
    //     // if(!$this->attributes['completed_at'] && $this->attributes['phase_id'] == )
    //     // {
    //     //     $this->attributes['completed_at'] = now();
    //     // }
    // }
 
}
