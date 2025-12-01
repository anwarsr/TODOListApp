<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * TaskPolicy
 * 
 * Policy untuk otorisasi aksi pada Task
 * Memastikan user hanya bisa mengakses task miliknya sendiri
 * 
 * @package App\Policies
 */
class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Cek apakah user boleh melihat task
     * 
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function view(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }

    /**
     * Cek apakah user boleh mengupdate task
     * 
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function update(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }

    /**
     * Cek apakah user boleh menghapus task
     * 
     * @param User $user
     * @param Task $task
     * @return bool
     */
    public function delete(User $user, Task $task)
    {
        return $user->id === $task->user_id;
    }
}