<?php


namespace App\Http\View\Composers;


use App\Website;
use App\Traits\UserFeaturesTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class UserWebsitesComposer
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

            $websites = $websites = Website::where('user_id', $user->id)->orderBy('url', 'asc')->get();

            $view->with('websites', $websites)->with('range', $this->range());
        }
    }
}