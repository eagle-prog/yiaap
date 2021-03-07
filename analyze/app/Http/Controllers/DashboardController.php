<?php

namespace App\Http\Controllers;

use App\Recent;
use App\Stat;
use App\Traits\DateRangeTrait;
use App\User;
use App\Website;
use App\Plan;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use DateRangeTrait;

    public function index(Request $request)
    {
        $user = Auth::user();

        $plan = Plan::where([['amount_month', '=', 0], ['amount_year', '=', 0]])->first();

        $subscriptions = [];
        // Get all the subscriptions the user is currently active on
        foreach ($user->subscriptions as $subscription) {
            if (($subscription->recurring() || $subscription->onTrial() || $subscription->onGracePeriod()) && !$subscription->hasIncompletePayment()) {
                $subscriptions[] = $subscription;
            }
        }

        $range = $this->range();

        $visitors = Stat::whereIn('website_id', Website::select('id')->where('user_id', '=', $user->id))
            ->where('name', '=', 'visitors')
            ->whereBetween('date', [$range['from'], $range['to']])
            ->sum('count');

        $visitorsOld = Stat::whereIn('website_id', Website::select('id')->where('user_id', '=', $user->id))
            ->where('name', '=', 'visitors')
            ->whereBetween('date', [$range['from_old'], $range['to_old']])
            ->sum('count');

        $pageviews = Stat::whereIn('website_id', Website::select('id')->where('user_id', '=', $user->id))
            ->where('name', '=', 'pageviews')
            ->whereBetween('date', [$range['from'], $range['to']])
            ->sum('count');

        $pageviewsOld = Stat::whereIn('website_id', Website::select('id')->where('user_id', '=', $user->id))
            ->where('name', '=', 'pageviews')
            ->whereBetween('date', [$range['from_old'], $range['to_old']])
            ->sum('count');

        $search = $request->input('search');
        $sort = ($request->input('sort') == 'desc' ? 'desc' : 'asc');

        $websites = Website::with([
                'visitors' => function ($query) use($range) {
                    $query->whereBetween('date', [$range['from'], $range['to']]);
                },
                'pageviews' => function ($query) use($range) {
                    $query->whereBetween('date', [$range['from'], $range['to']]);
                }]
            )
            ->where('user_id', $user->id)
            ->when($search, function($query) use ($search) {
                return $query->searchURL($search);
            })
            ->orderBy('url', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort, 'from' => $range['from'], 'to' => $range['to']]);

        return view('dashboard.content', ['user' => $user, 'plan' => $plan, 'subscriptions' => $subscriptions, 'visitors' => $visitors, 'visitorsOld' => $visitorsOld, 'pageviews' => $pageviews, 'pageviewsOld' => $pageviewsOld, 'range' => $range, 'websites' => $websites]);
    }
}
