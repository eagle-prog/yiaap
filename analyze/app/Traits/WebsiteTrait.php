<?php


namespace App\Traits;

use App\Website;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait WebsiteTrait
{
    /**
     * Store a new website
     *
     * @param Request $request
     * @return Website
     */
    protected function websiteCreate(Request $request)
    {
        $user = Auth::user();

        $website = new Website;

        $website->url = parse_url(str_replace('://www.', '://', $request->input('url')))['host'];
        $website->user_id = $user->id;
        $website->privacy = $request->input('privacy');
        $website->password = $request->input('password');
        $website->email = $request->input('email');
        $website->exclude_bots = ($request->has('exclude_bots') ? $request->input('exclude_bots') : 1);
        $website->exclude_ips = $request->input('exclude_ips');
        $website->save();

        return $website;
    }

    /**
     * Update the website
     *
     * @param Request $request
     * @param Model $website
     * @return Website|Model
     */
    protected function websiteUpdate(Request $request, Model $website)
    {
        if ($request->has('privacy')) {
            $website->privacy = $request->input('privacy');
        }

        if ($request->has('email')) {
            $website->email = $request->input('email');
        }

        if ($request->has('password')) {
            $website->password = $request->input('password');
        }

        if ($request->has('exclude_bots')) {
            $website->exclude_bots = $request->input('exclude_bots');
        }

        if ($request->has('exclude_ips')) {
            $website->exclude_ips = $request->input('exclude_ips');
        }

        $website->save();

        return $website;
    }
}