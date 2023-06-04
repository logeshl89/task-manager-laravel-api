<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Task $task)
    {
        return $user->id === $task->user_id
            ? Response::allow()
            : Response::deny('You do not own this task.');
    }

    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id
            ? Response::allow()
            : Response::deny('You cannot updade this task.');
    }

    public function delete(User $user, Task $task)
    {
        return $user->id === $task->user_id
            ? Response::allow()
            : Response::deny('You cannot delete this task.');
    }
}
