<?php

namespace App\Policies;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ReplyPolicy
{    
    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Reply $reply): bool
    {
        if ($user->id === $reply->user_id || $user->isModerator()) {
            return true;
        } else {
            return false;
        }
    }
}
