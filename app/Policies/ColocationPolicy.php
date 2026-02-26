<?php

namespace App\Policies;

use App\Models\Colocation;
use App\Models\User;

class ColocationPolicy
{
    public function view(User $user, Colocation $colocation): bool
    {
        return $colocation->members->contains($user);
    }

    public function update(User $user, Colocation $colocation): bool
    {
        
        return $colocation->members()
            ->where('memberships.user_id', $user->id)
            ->where('memberships.role', 'owner') 
            ->exists();
    }
}