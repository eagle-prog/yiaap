<?php

namespace App\Observers;

use App\User;

class UserObserver
{
    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleting(User $user)
    {
        $user->stats()->delete();
        $user->recents()->delete();
        $user->websites()->delete();

        if ($user->isForceDeleting()) {
            foreach ($user->subscriptions as $subscription) {
                try {
                    // Cancel the subscription immediately
                    $subscription->cancelNow();
                } catch (\Exception $e) {}
            }

            try {
                // Remove all subscriptions
                $user->subscriptions()->delete();
            } catch (\Exception $e) {}
        } else {
            foreach ($user->subscriptions as $subscription) {
                try {
                    // Cancel the subscription at the end of its period
                    $subscription->cancel();
                } catch (\Exception $e) {}
            }
        }
    }
}
