<?php

namespace App\Http\Controllers;

use App\Traits\DateRangeTrait;
use App\Website;
use App\Http\Requests\CreateWebsiteRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use App\Traits\WebsiteTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WebsitesController extends Controller
{
    use WebsiteTrait, DateRangeTrait;

    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->input('search');
        $sort = ($request->input('sort') == 'desc' ? 'desc' : 'asc');

        $websites = Website::where('user_id', '=', $user->id)->orderBy('url', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort]);

        return view('websites.content', ['view' => 'list', 'websites' => $websites, 'range' => $this->range()]);
    }

    public function websitesNew()
    {
        return view('websites.content', ['view' => 'new']);
    }

    public function websitesEdit($id)
    {
        $user = Auth::user();

        $website = Website::where([['id', '=', $id], ['user_id', '=', $user->id]])->firstOrFail();

        return view('websites.content', ['view' => 'edit', 'website' => $website]);
    }

    /**
     * @param CreateWebsiteRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createWebsite(CreateWebsiteRequest $request)
    {
        $this->websiteCreate($request);

        $user = Auth::user();
        $user->has_websites = true;
        $user->save();

        return redirect()->route('dashboard')->with('success', __(':name has been created.', ['name' => parse_url($request->input('url'))['host']]));
    }

    /**
     * @param UpdateWebsiteRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateWebsite(UpdateWebsiteRequest $request, $id)
    {
        $user = Auth::user();

        $website = Website::where([['id', '=', $id], ['user_id', '=', $user->id]])->firstOrFail();

        $this->websiteUpdate($request, $website);

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteWebsite($id)
    {
        $user = Auth::user();

        $website = Website::where([['id', '=', $id], ['user_id', '=', $user->id]])->firstOrFail();

        $website->delete();

        $user->has_websites = Website::where('user_id', '=', $user->id)->count() > 0;
        $user->save();

        return redirect()->route('dashboard')->with('success', __(':name has been deleted.', ['name' => str_replace(['http://', 'https://'], '', $website->url)]));
    }
}
