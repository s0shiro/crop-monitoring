<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CropPlanting;
use Illuminate\Auth\Access\HandlesAuthorization;

class CropPlantingPolicy
{
    use HandlesAuthorization;

    public function update(User $user, CropPlanting $cropPlanting)
    {
        if ($user->hasRole('technician')) {
            return $cropPlanting->technician_id === $user->id;
        }
        return false;
    }

    public function delete(User $user, CropPlanting $cropPlanting)
    {
        if ($user->hasRole('technician')) {
            return $cropPlanting->technician_id === $user->id;
        }
        return false;
    }
}
