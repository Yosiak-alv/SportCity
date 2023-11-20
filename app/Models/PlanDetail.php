<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PlanDetail extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function plan():BelongsTo
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
