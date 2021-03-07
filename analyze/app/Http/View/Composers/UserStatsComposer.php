<?php


namespace App\Http\View\Composers;


use App\Website;
use App\Stat;
use App\Traits\UserFeaturesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class UserStatsComposer
{
    use UserFeaturesTrait;

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $features = $this->getFeatures($user);

            $stats = [
                'pageviews' => Stat::where('name', '=', 'pageviews')
                    ->whereIn('website_id', Website::select('id')->where('user_id', '=', $user->id))
                    ->whereBetween('date', [$features['start_date'], $features['end_date']])
                    ->sum('count')
            ];

            $view->with('stats', $stats)->with('userFeatures', $features);
        }
    }
}