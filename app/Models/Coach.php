<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Coach extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, SoftDeletes, HasRoles;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function training_session_coaches():BelongsToMany
    {
        return $this->belongsToMany(TrainingSession::class,'training_sessions_coaches');
    }
    public function gym(): BelongsTo
    {
        return $this->belongsTo(Gym::class);
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

    public function scopeFilter($query , array $filters)
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
        });
    }
}
