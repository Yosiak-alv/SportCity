<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes ,HasUuids;

    protected $guarded = [
        'id',
        'uuid'
    ];

    public function uniqueIds()
    {
        return ['uuid'];
    }

    public function purchaseItems():HasMany
    {
        return $this->hasMany(PurchaseItems::class,'purchase_id');
    }
}
