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

    public function scopeFilter($query , array $filters)
    {
        $query->when($filters['search'] ?? false, function( $query, $search){
            $query->where(fn($query) =>
                $query->where('id','like','%'.$search.'%')
                    ->orWhere('item_count','like','%'.$search.'%')
                    ->orWhere('taxes','like','%'.$search.'%')
                    ->orWhere('sub_total','like','%'.$search.'%')
                    ->orWhere('total','like','%'.$search.'%')
                    ->orWhere(function ($query) use ($search) {
                        $query->where(function ($query) use ($search) {
                            if ($search === 'canceled') {
                                $query->where('canceled', '1');
                            } elseif ($search === 'ok') {
                                $query->where('canceled', '0');
                            }
                        })->orWhere('canceled', 'like', '%' . $search . '%');
                    })
            );
        });
    }
}
