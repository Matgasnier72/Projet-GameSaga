<?php

namespace App\Policies;

use App\Models\User;
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
    public function update(?User $user, User $userTarget)
    {
        if ($user->isAdmin()) {
            return true;
        }
        return $user->id == $userTarget->id;
    }
    public function destroy(?User $user){
        $user->delete();
        return response();
    }
}
