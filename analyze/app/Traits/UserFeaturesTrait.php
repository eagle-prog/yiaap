<?php


namespace App\Traits;

use App\Plan;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

trait UserFeaturesTrait
{
    use DateRangeTrait;

    /**
     * @param $user
     * @return array
     */
    protected function getFeatures($user)
    {
        $subscriptions = $features = [];
        // Get all the subscriptions the user is currently active on
        if ($user) {
            foreach ($user->subscriptions as $subscription) {
                if (($subscription->recurring() || $subscription->onTrial() || $subscription->onGracePeriod()) && !$subscription->hasIncompletePayment()) {
                    $subscriptions[] = $subscription->name;

                    $features['start_date'] = array_key_last($this->calcAllDates($subscription->created_at->format('Y-m-d'), Carbon::now()->format('Y-m-d'), 'month', 'Y-m-d', ['count' => 0]));
                }
            }

            // If the user has no subscription
            // Use the date from his registration date
            if (empty($subscriptions)) {
                $features['start_date'] = array_key_last($this->calcAllDates($user->created_at->format('Y-m-d'), Carbon::now()->format('Y-m-d'), 'month', 'Y-m-d', ['count' => 0]));
            }

            $features['end_date'] = Carbon::createFromFormat('Y-m-d', $features['start_date'])->addMonths(1)->format('Y-m-d');
        }

        // Get the plans
        $plans = Plan::whereIn('name', $subscriptions)->orWhere([['amount_month', '=', 0], ['amount_year', '=', 0]])->get()->toArray();

        foreach ($plans as $plan) {
            foreach ($plan as $key => $value) {
                if (in_array($key, ['option_pageviews'])) {
                    if (!isset($features[$key])) {
                        $features[$key] = 0;
                    }

                    // If unlimited
                    if ($value == -1) {
                        $features[$key] = $value;
                    }
                    // If the plan option has a value, and is not -1, and is higher than what was previously se
                    elseif ($value > 0 && $features[$key] != -1 && $value > $features[$key]) {
                        $features[$key] = $value;
                    }
                }
            }
        }

        return $features;
    }
}