<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gym extends Model
{
    use HasFactory, SoftDeletes;

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function clients():HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function users():HasMany
    {
        return $this->hasMany(User::class);
    }

    public function trainingSessions():HasMany
    {
        return $this->hasMany(TrainingSession::class);
    }
}
