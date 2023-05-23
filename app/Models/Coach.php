<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coach extends Model
{
    use HasFactory;

    public function training_session_coaches():BelongsToMany
    {
        return $this->belongsToMany(TrainingSession::class,'training_session_coaches');
    }
}
