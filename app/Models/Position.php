<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Position extends Model
{
    protected $fillable = ['title', 'role_id'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}