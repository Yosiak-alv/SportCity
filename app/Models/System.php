<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class System extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function system_client() :BelongsToMany
    {
        return $this->belongsToMany(Client::class,'system_client');
    }
}
