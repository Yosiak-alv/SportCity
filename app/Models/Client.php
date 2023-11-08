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
use Spatie\Permission\Traits\HasRoles;

class Client extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, SoftDeletes, HasRoles;

    protected $hidden = [
        'password',
        'remember_token',
    ];
    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
    }
    public function system_client() : BelongsToMany
    {
        return $this->belongsToMany(System::class,'system_client')->withPivot('condition');
    }

    public function attendances_training_sessions():BelongsToMany
    {
        return $this->belongsToMany(TrainingSession::class,'attendances')->withPivot('attendance_date')->orderBy('attendance_date','DESC');
    }

    public function suscriptions():HasMany
    {
        return $this->hasMany(Suscription::class)->orderBy('created_at','DESC');
    }

    public function purchases():HasMany
    {
        return $this->hasMany(Purchase::class)->orderBy('created_at','DESC');
    }
    // entender que es !!
    // los items deleted devuelven un not found con y sin softdeletes
    //pero este metodo ayuda a que en soft deletes se pueda acceder a el como si 
    // no estuviera eliminado
    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }
    
    //FILTERSCOPE

    public function scopeFilter($query , array $filters, $userGymId)
    {
        $query->when($filters['search'] ?? false, function( $query, $search){
            $query->where(fn($query) =>
                $query->where('name','like','%'.$search.'%')
                    ->orWhere('lastname','like','%'.$search.'%')
                    ->orWhere('dui','like','%'.$search.'%')
                    ->orWhere('phone','like','%'.$search.'%')
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

}
