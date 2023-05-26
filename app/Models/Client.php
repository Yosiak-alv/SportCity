<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, SoftDeletes;
    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }
    public function system_client() : BelongsToMany
    {
        return $this->belongsToMany(System::class,'system_client')->withPivot('condition');
    }

    public function cardTransactions() : HasMany
    {
        return $this->hasMany(CardTransaction::class);
    }

    public function cashTransactions(): HasMany
    {
        return $this->hasMany(CashTransaction::class);
    }

    public function attendances_training_sessions():BelongsToMany
    {
        return $this->belongsToMany(TrainingSession::class,'attendances')->withPivot('attendance_date');
    }

    public function suscriptions():HasMany
    {
        return $this->hasMany(Suscription::class);
    }

    public function purchases():HasMany
    {
        return $this->hasMany(Purchase::class);
    }

}
