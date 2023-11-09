<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    // entender que es !!
    // los items deleted devuelven un not found con y sin softdeletes
    //pero este metodo ayuda a que en soft deletes se pueda acceder a el como si 
    // no estuviera eliminado
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }
    public function scopeFilter($query , array $filters, $userGymId)
    {
        $query->when($filters['search'] ?? false, function( $query, $search){
            $query->where(fn($query) =>
                $query->where('name','like','%'.$search.'%')
                    ->orWhere('unit_price','like','%'.$search.'%')
                    ->orWhere('quantity','like','%'.$search.'%')
            );
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        })->when($filters['gym'] ?? $userGymId, function ($query, $gymId) {
            $query->where('gym_id', $gymId);
        });
    }

    public function purchaseItems():HasMany
    {
        return $this->hasMany(PurchaseItems::class,'purchase_id');
    }
    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }

    //ATTRIBUTES
    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->diffForHumans();
    }
    public function getUpdatedAtAttribute($updated_at)
    {
        return Carbon::parse($updated_at)->diffForHumans();
    }
}
