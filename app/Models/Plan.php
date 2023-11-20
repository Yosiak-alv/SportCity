<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function suscriptions():HasMany
    {
        return $this->hasMany(Suscription::class);
    }
    public function details(): HasMany{
        return $this->hasMany(PlanDetail::class, 'plan_id');
    }
}
