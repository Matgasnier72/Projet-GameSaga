<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Image;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{

    public function __construct(){

    }
    use HandlesAuthorization;
    public function me(?User $user)
    {
        return true;
    }
    public function store(?User $user, Image $imageTarget)
    {
        if ($user->isAdmin() || $user->isRedacteur()) {
            return true;
        }
        return false;
    }
    public function destroy(?User $user){
        $user->delete();
        return response();
    }
}
