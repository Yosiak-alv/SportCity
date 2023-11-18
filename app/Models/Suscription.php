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

    public function scopeFilter($query , array $filters)
    {
        $query->when($filters['search'] ?? false, function( $query, $search){
            $query->where(fn($query) =>
                $query->where('id','like','%'.$search.'%')
                ->orWhere('ends_at','like','%'.$search.'%')
                ->orWhere(function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        if ($search === 'canceled') {
                            $query->where('canceled', '1');
                        } elseif ($search === 'active') {
                            $query->where('canceled', '0');
                        }
                    })->orWhere('canceled', 'like', '%' . $search . '%');
                })
            )->orWhereHas('client', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->orWhereHas('plan', function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('price','like','%'.$search.'%');
            });
        });
    }
}
