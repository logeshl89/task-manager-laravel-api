<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function view(User $user, User $viewUser)
    {
        return $user->id === $viewUser->id
            ? Response::allow()
            : Response::deny('You do not own this user.');
    }

    public function update(User $user, User $updateUser)
    {
        return $user->id === $updateUser->id
            ? Response::allow()
            : Response::deny('You cannot update this user.');
    }

    public function delete(User $user, User $deleteUser)
    {
        return $user->id === $deleteUser->id
            ? Response::allow()
            : Response::deny('You cannot delete this user.');
    }
}
