<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Colocation extends Model
{
    protected $fillable = ['name', 'status'];

    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'memberships')
                    ->withPivot('role', 'left_at')
                    ->withTimestamps();
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ColocationImage::class);
    }
}