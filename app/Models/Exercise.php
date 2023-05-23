<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Exercise extends Model
{
    use HasFactory;

    public function training_session_exercises():BelongsToMany
    {
        return $this->belongsToMany(TrainingSession::class,'training_session_exercises');
    }
}
