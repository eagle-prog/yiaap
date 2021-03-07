<?php

namespace App\Http\Controllers;

use App\Cronjob;
use App\Mail\LimitExceededMail;
use App\Mail\ReportMail;
use App\Recent;
use App\Stat;
use App\Traits\UserFeaturesTrait;
use App\User;
use App\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class CronjobController extends Controller
{
    use UserFeaturesTrait;

    /**
     * This method checks the account limit stats of the users and takes the required actions,
     * such as disabling the tracking access and sends out notification emails.
     */
    public function check()
    {
        foreach (User::where('has_websites', '=', 1)->cursor() as $user) {
            // Get the user's features
            $features = $this->getFeatures($user);

            // Get the total pageviews count of user's account for the required period
            $pageviews = Stat::where('name', '=', 'pageviews')
                ->whereIn('website_id', Website::select('id')->where('user_id', '=', $user->id))
                ->whereBetween('date', [$features['start_date'], $features['end_date']])
                ->sum('count');

            // If the pageviews have exceeded the user's current limits
            if ($features['option_pageviews'] != -1 && $pageviews >= $features['option_pageviews']) {
                // If the user's tracking was not previously disabled
                if ($user->can_track) {
                    $user->can_track = false;
                    $user->save();

                    // If the website & the user has the option to be emailed when the plan exceeds the limits
                    if ($user->email_account_limit) {
                        // Send out the email
                        try {
                            Mail::to($user->email)->locale($user->locale)->send(new LimitExceededMail());
                        } catch (\Exception $e) {}
                    }
                }
            } else {
                // If the user's tracking was not previously enabled
                if (!$user->can_track) {
                    $user->can_track = true;
                    $user->save();
                }
            }
        }

        $cronjob = new Cronjob;
        $cronjob->name = 'check';
        $cronjob->save();

        return response()->json([
            'status' => 200
        ], 200);
    }

    public function email(Request $request)
    {
        $to = Carbon::yesterday();

        if ($request->has('weekly')) {
            $from = (clone $to)->subDays(6);
        } else {
            $from = (clone $to)->subDays(29);
        }

        foreach (User::where('has_websites', '=', 1)->cursor() as $user) {
            $websites = Website::with([
                    'visitors' => function ($query) use($from, $to) {
                        $query->whereBetween('date', [$from->format('Y-m-d'), $to->format('Y-m-d')]);
                    },
                    'pageviews' => function ($query) use($from, $to) {
                        $query->whereBetween('date', [$from->format('Y-m-d'), $to->format('Y-m-d')]);
                    }]
                )
                ->where([['user_id', '=', $user->id], ['email', '=', 1]])->get();

            $stats = [];
            foreach ($websites as $website) {
                $stats[] = ['url' => $website->url, 'visitors' => $website->visitors->sum('count') ?? 0, 'pageviews' => $website->pageviews->sum('count') ?? 0];
            }

            // If the user has any websites with email notifications enabled
            if ($stats) {
                try {
                    Mail::to($user->email)->locale($user->locale)->send(new ReportMail($stats, ['from' => $from->format('Y-m-d'), 'to' => $to->format('Y-m-d')]));
                } catch (\Exception $e) {}
            }
        }

        $cronjob = new Cronjob;
        $cronjob->name = 'email';
        $cronjob->save();

        return response()->json([
            'status' => 200
        ], 200);
    }

    /**
     * This method takes care of cleaning the recent visitors
     */
    public function clean()
    {
        Recent::truncate();

        $cronjob = new Cronjob;
        $cronjob->name = 'clean';
        $cronjob->save();

        return response()->json([
            'status' => 200
        ], 200);
    }
}
