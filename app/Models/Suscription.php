<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suscription extends Model
{
    use HasFactory;

    public function client():BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan() :BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
