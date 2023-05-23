<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Purchase extends Model
{
    use HasFactory;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function client() : BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function purchaseItems () : HasMany
    {
        return $this->hasMany(PurchaseItems::class,'purchase_id');
    }
}
