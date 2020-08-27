<?php

namespace App\Policies;

use App\{User, Story};
use Illuminate\Auth\Access\HandlesAuthorization;

class StoryPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function edit(User $user, Story $story)
    {
        return $user->id == $story->user_id;
    }
}
