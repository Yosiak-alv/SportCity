<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TrainingSession extends Model
{
    use HasFactory;

    public function gym() :BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function attendancesClients():BelongsToMany
    {
        return $this->belongsToMany(Client::class,'attendances')->withPivot('attendance_date');;
    }

    public function training_sessions_exercises():BelongsToMany
    {
        return $this->belongsToMany(Exercise::class,'training_sessions_exercises')->withPivot(['repetitions','instructions']);
    }

    public function training_sessions_coaches():BelongsToMany
    {
        return $this->belongsToMany(Coach::class,'training_sessions_coaches');
    }
}
