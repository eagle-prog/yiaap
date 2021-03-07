<?php

namespace App\Http\Controllers;

use App\Cronjob;
use App\Http\Requests\UpdateSettingsAnalyticsRequests;
use App\Http\Requests\UpdateSettingsGeneralRequest;
use App\Http\Requests\UpdateWebsiteRequest;
use App\Traits\WebsiteTrait;
use App\Website;
use App\Http\Requests\CreateLanguageRequest;
use App\Http\Requests\CreatePageRequest;
use App\Http\Requests\CreatePlanRequest;
use App\Http\Requests\CreateSubscriptionRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateSettingsAppearanceRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Http\Requests\UpdateSettingsLicenseRequest;
use App\Http\Requests\UpdateSettingsPaymentRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Language;
use App\Page;
use App\Plan;
use App\Setting;
use App\Subscription;
use App\Traits\UserTrait;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stripe;

class AdminController extends Controller
{
    use UserTrait, WebsiteTrait;

    public function dashboard(Request $request)
    {
        $user = Auth::user();

        $stats = [
            'users' => User::withTrashed()->count(),
            'subscriptions' => Subscription::count(),
            'plans' => Plan::withTrashed()->count(),
            'pages' => Page::count(),
            'websites' => Website::count(),
            'cronjobs' => Cronjob::count()
        ];

        $users = User::withTrashed()->orderBy('id', 'desc')->limit(10)->get();
        $subscriptions = $websites = null;
        if (config('settings.stripe')) {
            $subscriptions = Subscription::orderBy('id', 'desc')->limit(10)->get();
        } else {
            $websites = Website::orderBy('id', 'desc')->limit(10)->get();
        }

        return view('admin.dashboard.content', ['stats' => $stats, 'users' => $users, 'subscriptions' => $subscriptions, 'websites' => $websites, 'user' => $user]);
    }

    public function settingsGeneral()
    {
        return view('admin.content', ['view' => 'admin.settings.general']);
    }

    public function settingsAppearance()
    {
        return view('admin.content', ['view' => 'admin.settings.appearance']);
    }

    public function settingsEmail()
    {
        return view('admin.content', ['view' => 'admin.settings.email']);
    }

    public function settingsSocial()
    {
        return view('admin.content', ['view' => 'admin.settings.social']);
    }

    public function settingsPayment()
    {
        return view('admin.content', ['view' => 'admin.settings.payment']);
    }

    public function settingsInvoice()
    {
        return view('admin.content', ['view' => 'admin.settings.invoice']);
    }

    public function settingsRegistration()
    {
        return view('admin.content', ['view' => 'admin.settings.registration']);
    }

    public function settingsLegal()
    {
        return view('admin.content', ['view' => 'admin.settings.legal']);
    }

    public function settingsContact()
    {
        return view('admin.content', ['view' => 'admin.settings.contact']);
    }

    public function settingsCaptcha()
    {
        return view('admin.content', ['view' => 'admin.settings.captcha']);
    }

    public function settingsCronjob(Request $request)
    {
        $search = $request->input('search');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        $cronjobs = Cronjob::when($search, function($query) use($search) {
                return $query->search($search);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort]);

        return view('admin.content', ['view' => 'admin.settings.cronjob', 'cronjobs' => $cronjobs]);
    }

    public function settingsAnalytics()
    {
        return view('admin.content', ['view' => 'admin.settings.analytics']);
    }

    public function languages(Request $request)
    {
        $search = $request->input('search');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        $languages = Language::when($search, function($query) use($search) {
                return $query->search($search);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort]);

        return view('admin.content', ['view' => 'admin.languages.list', 'languages' => $languages]);
    }

    public function languagesNew()
    {
        return view('admin.content', ['view' => 'admin.languages.new']);
    }

    public function languagesEdit($id)
    {
        $language = Language::where('code', $id)->firstOrFail();

        return view('admin.content', ['view' => 'admin.languages.edit', 'id' => $id, 'languages' => Language::all(), 'language' => $language]);
    }

    public function users(Request $request)
    {
        $search = $request->input('search');
        $role = $request->input('role');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');
        $by = $request->input('by');

        $users = User::withTrashed()
            ->when(isset($role) && is_numeric($role), function($query) use ($role) {
                return $query->searchRole($role);
            })
            ->when($search, function($query) use ($search, $by) {
                if($by == 'email') {
                    return $query->searchEmail($search);

                }
                return $query->searchName($search);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'by' => $by, 'role' => $role, 'sort' => $sort]);

        return view('admin.content', ['view' => 'admin.users.list', 'users' => $users]);
    }

    public function usersNew()
    {
        return view('admin.content', ['view' => 'admin.users.new']);
    }

    public function usersEdit(Request $request, $id)
    {
        $user = User::withTrashed()
            ->where('id', $id)
            ->firstOrFail();

        $stats = [
            'websites' => Website::where('user_id', $user->id)->count(),
            'subscriptions' => Subscription::where('user_id', $user->id)->count()
        ];

        return view('admin.content', ['view' => 'settings.account', 'admin' => true, 'stats' => $stats, 'user' => $user]);
    }

    public function pages(Request $request)
    {
        $search = $request->input('search');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        $pages = Page::when($search, function($query) use($search) {
                return $query->search($search);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort]);

        return view('admin.content', ['view' => 'admin.pages.list', 'pages' => $pages]);
    }

    public function pagesNew()
    {
        return view('admin.content', ['view' => 'admin.pages.new']);
    }

    public function pagesEdit($id)
    {
        $page = Page::where('id', $id)->firstOrFail();

        return view('admin.content', ['view' => 'admin.pages.edit', 'page' => $page]);
    }

    public function plans(Request $request)
    {
        $search = $request->input('search');
        $visibility = $request->input('visibility');
        $status = $request->input('status');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        $stripe = config('settings.stripe');

        $plans = Plan::withTrashed()
            ->when(!$stripe, function($query) {
                return $query->where([['amount_month', '=', 0], ['amount_year', '=', 0]]);
            })
            ->when($search, function($query) use($search) {
                return $query->search($search);
            })
            ->when(isset($visibility) && is_numeric($visibility), function($query) use ($visibility) {
                return $query->visibility((int)$visibility);
            })
            ->when(isset($status) && is_numeric($status), function($query) use ($status) {
                if ($status) {
                    $query->whereNotNull('deleted_at');
                } else {
                    $query->whereNull('deleted_at');
                }
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'visibility' => $visibility, 'status' => $status, 'sort' => $sort]);

        return view('admin.content', ['view' => 'admin.plans.list', 'plans' => $plans]);
    }

    public function plansNew()
    {
        return view('admin.content', ['view' => 'admin.plans.new']);
    }

    public function plansEdit($id)
    {
        $plan = Plan::withTrashed()->where('id', $id)->firstOrFail();

        return view('admin.content', ['view' => 'admin.plans.edit', 'plan' => $plan]);
    }

    public function subscriptions(Request $request)
    {
        $userId = $request->input('user_id');
        $search = $request->input('search');
        $status = $request->input('status');
        $plan = $request->input('plan');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        $subscriptions = Subscription::with(['user' => function($query) {
            return $query->withTrashed();
        }])
            ->when(isset($status) && !empty($status), function($query) use ($status) {
                return $query->status($status);
            })
            ->when(isset($plan) && !empty($plan), function($query) use ($plan) {
                return $query->plan($plan);
            })
            ->when($userId, function($query) use($userId) {
                return $query->userId($userId);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'status' => $status, 'plan' => $plan, 'user_id' => $userId]);

        // Get all the plans
        $plans = Plan::where([['amount_month', '>', 0], ['amount_year', '>', 0]])->get();

        $filters = [];

        if ($userId) {
            $user = User::where('id', '=', $userId)->first();
            if ($user) {
                $filters['user'] = $user->name;
            }
        }

        return view('admin.content', ['view' => 'admin.subscriptions.list', 'subscriptions' => $subscriptions, 'plans' => $plans, 'filters' => $filters]);
    }

    public function subscriptionsNew()
    {
        $plans = Plan::where([['amount_month', '>', 0], ['amount_year', '>', 0]])->get();

        return view('admin.content', ['view' => 'admin.subscriptions.new', 'plans' => $plans]);
    }

    public function subscriptionsEdit($id)
    {
        $subscription = Subscription::where('id', $id)->firstOrFail();
        $plan = Plan::withTrashed()->where('name', $subscription->name)->firstOrFail();
        $user = User::withTrashed()->where('id', $subscription->user_id)->firstOrFail();

        return view('admin.content', ['view' => 'settings.payments.subscriptions.edit', 'admin' => true, 'subscription' => $subscription, 'plan' => $plan, 'user' => $user]);
    }

    public function websites(Request $request)
    {
        $userId = $request->input('user_id');
        $search = $request->input('search');
        $sort = ($request->input('sort') == 'asc' ? 'asc' : 'desc');

        $websites = Website::when($search, function($query) use($search) {
                return $query->searchURL($search);
            })
            ->when($userId, function($query) use($userId) {
                return $query->userId($userId);
            })
            ->orderBy('id', $sort)
            ->paginate(config('settings.paginate'))
            ->appends(['search' => $search, 'sort' => $sort, 'user_id' => $userId]);

        $filters = [];

        if ($userId) {
            $user = User::where('id', '=', $userId)->first();
            if ($user) {
                $filters['user'] = $user->name;
            }
        }

        return view('admin.content', ['view' => 'admin.websites.list', 'websites' => $websites, 'filters' => $filters]);
    }

    public function websitesEdit($id)
    {
        $website = Website::where('id', $id)->firstOrFail();

        return view('admin.content', ['view' => 'websites.edit', 'admin' => true, 'website' => $website]);
    }

    public function license() {
        return view('admin.content', ['view' => 'admin.license.index']);
    }

    /**
     * Update the general settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsGeneral(UpdateSettingsGeneralRequest $request)
    {
        // The rows to be updated
        $rows = ['title', 'tagline', 'index', 'paginate', 'timezone', 'tracking_code'];

        foreach ($rows as $row) {
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the registration settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsRegistration(Request $request)
    {
        // The rows to be updated
        $rows = ['registration_registration', 'registration_captcha', 'registration_verification'];

        foreach ($rows as $row) {
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the contact settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsContact(Request $request)
    {
        // The rows to be updated
        $rows = ['contact_email'];

        foreach ($rows as $row) {
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the captcha settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsCaptcha(Request $request)
    {
        // The rows to be updated
        $rows = ['captcha_site_key', 'captcha_secret_key', 'captcha_registration', 'captcha_contact'];

        foreach ($rows as $row) {
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the legal settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsLegal(Request $request)
    {
        // The rows to be updated
        $rows = ['legal_terms_url', 'legal_privacy_url', 'legal_cookie_url'];

        foreach ($rows as $row) {
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the appearance
     *
     * @param UpdateSettingsAppearanceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsAppearance(UpdateSettingsAppearanceRequest $request)
    {
        if ($request->validated()) {
            // The rows to be updated
            $rows = ['logo', 'favicon'];

            foreach ($rows as $row) {
                if ($request->has($row)) {
                    if($request->hasFile($row)) {
                        $fileName = $request->file($row)->hashName();

                        // Check if the file exists
                        if (file_exists(public_path('uploads/brand/' . config('settings.' . $row)))) {
                            unlink(public_path('uploads/brand/' . config('settings.' . $row)));
                        }

                        // Save the file
                        $request->file($row)->move(public_path('uploads/brand'), $fileName);
                    }

                    // Update the database
                    Setting::where('name', $row)->update(['value' => $fileName]);

                    session()->flash('success', __('Settings saved.'));
                }
            }

            // The rows to be updated
            $rows = ['theme', 'custom_css'];

            foreach ($rows as $row) {
                // Update the database
                Setting::where('name', $row)->update(['value' => $request->input($row)]);
            }
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the email settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsEmail(Request $request)
    {
        // The rows to be updated
        $rows = ['email_driver', 'email_host', 'email_port', 'email_encryption', 'email_address', 'email_username', 'email_password'];

        foreach ($rows as $row) {
            // Update the database
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the social settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsSocial(Request $request)
    {
        // The rows to be updated
        $rows = ['social_facebook', 'social_twitter', 'social_instagram', 'social_youtube'];

        foreach ($rows as $row) {
            // Update the database
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the cronjob settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsCronjob()
    {
        Setting::where('name', '=', 'cronjob_key')->update(['value' => Str::random(60)]);

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the analytics settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsAnalytics(UpdateSettingsAnalyticsRequests $request)
    {
        // The rows to be updated
        $rows = ['demo_url', 'cdn_url'];

        foreach ($rows as $row) {
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the payment settings
     *
     * @param UpdateSettingsPaymentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsPayment(UpdateSettingsPaymentRequest $request)
    {
        // The rows to be updated
        $rows = ['stripe', 'stripe_key', 'stripe_secret', 'stripe_wh_secret'];

        foreach ($rows as $row) {
            // Update the database
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Update the invoice settings
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettingsInvoice(Request $request)
    {
        // The rows to be updated
        $rows = ['invoice_vendor', 'invoice_address', 'invoice_city', 'invoice_state', 'invoice_postal_code', 'invoice_country', 'invoice_phone', 'invoice_vat_number'];

        foreach ($rows as $row) {
            // Update the database
            Setting::where('name', $row)->update(['value' => $request->input($row)]);
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Emulate a subscription
     *
     * @param CreateSubscriptionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createSubscription(CreateSubscriptionRequest $request)
    {
        $user = User::where('email', '=', $request->input('email'))->firstOrFail();

        $plan = Plan::where('plan_month', '=', $request->input('plan'))->orWhere('plan_year', '=', $request->input('plan'))->firstOrFail();

        // Cancel all previous subscriptions
        foreach ($user->subscriptions as $subscription) {
            try {
                // Cancel the subscription immediately
                $subscription->cancelNow();
            } catch (\Exception $e) {}
        }

        $subscription = new Subscription;

        $end_date = Carbon::now()->add($request->trial_days, 'day');

        $subscription->user_id = $user->id;
        $subscription->name = $plan->name;
        $subscription->stripe_status = 'emulated';
        $subscription->stripe_id = '';
        $subscription->stripe_plan = $request->input('plan');
        $subscription->quantity = 1;
        $subscription->trial_ends_at = $end_date;
        $subscription->ends_at = $end_date;
        $subscription->save();

        return redirect()->route('admin.subscriptions')->with('success', __(':name has been created.', ['name' => $plan->name]));
    }

    /**
     * Delete a subscription model
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteSubscription($id)
    {
        $subscription = Subscription::where([['id', '=', $id], ['stripe_status', '=', 'emulated']])->firstOrFail();

        Subscription::destroy($id);

        return redirect()->route('admin.subscriptions')->with('success', __(':name has been deleted.', ['name' => $subscription->name]));
    }

    /**
     * Upload language files
     *
     * @param CreateLanguageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createLanguage(CreateLanguageRequest $request)
    {
        if ($request->validated()) {

            $file = $this->readLanguage($request);
            $this->uploadLanguage($request, $file);

            // Update the database
            Language::updateOrCreate(['code' => $file->lang_code], ['name' => $file->lang_name, 'dir' => $file->lang_dir]);

            session()->flash('success', __(':name language uploaded.', ['name' => $file->lang_name]));
        }

        return redirect()->route('admin.languages');
    }

    /**
     * Read the Language file contents
     *
     * @param Request $request
     * @return mixed
     */
    private function readLanguage(Request $request)
    {
        $uploadedFile = file_get_contents($request->file('language'));
        $file = json_decode($uploadedFile);

        return $file;
    }

    /**
     * Upload the language file on disk
     *
     * @param Request $request
     * @param $file
     */
    private function uploadLanguage(Request $request, $file)
    {
        Storage::disk('languages')->put($file->lang_code . '.json', File::get($request->file('language')));
    }

    /**
     * Update the Language file
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateLanguage(Request $request, $id)
    {
        // Get the language
        $language = Language::findOrFail($id);

        // If the current language is not default
        if ($language->default == 0) {
            if ($request->has('default')) {
                // Reset the default language
                Language::query()->update(['default' => 0]);

                // Set the new default language
                $language->default = 1;
                $language->save();
            }
        }

        return redirect()->route('admin.languages.edit', $id)->with('success', __('Settings saved.'));
    }

    /**
     * Delete the Language file
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteLanguage($id)
    {
        // If there's more than 1 language available
        if (Language::count() > 1) {
            // Get the language
            $language = Language::findOrFail($id);

            // If the language to be deletes is set as default
            if ($language->default) {
                $redirect = redirect()->route('admin.languages')->with('error', __('The default language can\'t be deleted.'));
            } else {
                // Delete the database record
                Language::destroy($id);

                // Delete the file
                Storage::disk('languages')->delete($id . '.json');

                $redirect = redirect()->route('admin.languages')->with('success', __(':name has been deleted.', ['name' => $language->name]));
            }
        } else {
            $redirect = redirect()->route('admin.languages')->with('error', __('The default language can\'t be deleted.'));
        }

        return $redirect;
    }

    /**
     * Create the Page
     *
     * @param CreatePageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPage(CreatePageRequest $request)
    {
        $page = new Page;

        $page->title = $request->input('title');
        $page->slug = $request->input('slug');
        $page->footer = $request->input('footer') == 1 ? 1 : 0;
        $page->content = $request->input('content');

        $page->save();

        return redirect()->route('admin.pages')->with('success', __(':name has been created.', ['name' => $request->input('title')]));
    }

    /**
     * Update the Page
     *
     * @param UpdatePageRequest $request
     * @param $id
     * @return mixed
     */
    public function updatePage(UpdatePageRequest $request, $id)
    {
        $page = Page::findOrFail($id);

        $page->title = $request->input('title');
        $page->slug = $request->input('slug');
        $page->footer = $request->input('footer') == 1 ? 1 : 0;
        $page->content = $request->input('content');

        $page->save();

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Delete the Page
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deletePage($id)
    {
        $page = Page::findOrFail($id);

        Page::destroy($id);

        return redirect()->route('admin.pages')->with('success', __(':name has been deleted.', ['name' => $page->title]));
    }

    /**
     * Create the Plan
     *
     * @param CreatePlanRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPlan(CreatePlanRequest $request)
    {
        $plan = new Plan;

        try {
            Stripe\Stripe::setApiKey(config('cashier.secret'));
            $stripeProduct = Stripe\Product::create([
                "name" => $request->input('name'),
                "type" => 'service'
            ]);

            $monthlyPlan = Stripe\Plan::create([
                "product" => $stripeProduct->id,
                "amount" => $request->input('amount_month'),
                "interval" => 'month',
                "currency" => $request->input('currency')
            ]);

            $yearlyPlan = Stripe\Plan::create([
                "product" => $stripeProduct->id,
                "amount" => $request->input('amount_year'),
                "interval" => 'year',
                "currency" => $request->input('currency')
            ]);

            $plan->product = $stripeProduct->id;
            $plan->name = $request->input('name');
            $plan->description = $request->input('description');
            $plan->visibility = $request->input('visibility');
            $plan->trial_days = $request->input('trial_days');
            $plan->currency = $request->input('currency');
            $plan->plan_month = $monthlyPlan->id;
            $plan->plan_year = $yearlyPlan->id;
            $plan->amount_month = $request->input('amount_month');
            $plan->amount_year = $request->input('amount_year');
            $plan->coupons = $request->input('coupons');
            $plan->option_pageviews = $request->input('option_pageviews');
            $plan->save();
        } catch (\Exception $e) {
            $request->flash();
            return redirect()->route('admin.plans.new')->with('error', $e->getMessage());
        }

        return redirect()->route('admin.plans')->with('success', __(':name has been created.', ['name' => $request->input('name')]));
    }

    /**
     * Update the Plan
     *
     * @param UpdatePlanRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePlan(UpdatePlanRequest $request, $id)
    {
        $plan = Plan::withTrashed()->findOrFail($id);

        // If the payments module is not enabled
        if (!config('settings.stripe')) {
            // Prevent updating any plans other than the default one
            if($plan->amount_month > 0 || $plan->amount_year > 0) {
                abort(404);
            }
        }

        if ($plan->amount_month && $plan->amount_year) {
            try {
                Stripe\Stripe::setApiKey(config('cashier.secret'));
                Stripe\Product::update($plan->product, [
                    'name' => $request->input('name')
                ]);
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }

            // Update the subscriptions with the new plan name
            Subscription::where('name', $plan->name)->update(['name' => $request->input('name')]);

            $plan->coupons = $request->input('coupons');
            $plan->trial_days = $request->input('trial_days');
        }
        $plan->name = $request->input('name');
        $plan->description = $request->input('description');
        $plan->visibility = $request->input('visibility');
        $plan->option_pageviews = $request->input('option_pageviews');
        $plan->save();

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Soft delete the Plan
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function disablePlan($id)
    {
        $plan = Plan::findOrFail($id);

        // Do not delete the default plan
        if ($plan->amount_month == 0 && $plan->amount_year == 0) {
            return redirect()->route('admin.plans')->with('error', __('The default plan can\'t be deleted.'));
        }

        try {
            Plan::destroy($id);
        } catch (\Exception $e) {
            return redirect()->route('admin.plans')->with('error', $e->getMessage());
        }

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Restore the Plan
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restorePlan($id)
    {
        $plan = Plan::withTrashed()->findOrFail($id);
        $plan->restore();

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Create the User
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createUser(CreateUserRequest $request)
    {
        $user = new User;

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->locale = App::getLocale();
        $user->timezone = config('settings.timezone');
        $user->api_token = Str::random(60);

        $user->save();

        $user->markEmailAsVerified();

        return redirect()->route('admin.users')->with('success', __(':name has been created.', ['name' => $request->input('name')]));
    }

    /**
     * Update the User
     *
     * @param UpdateUserRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateUser(UpdateUserRequest $request, $id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if (Auth::id() == $user->id && $request->input('role') == 0) {
            return back()->with('error', __('Operation denied.'));
        }

        $this->userUpdate($request, $user, true);

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Delete the User
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        if (Auth::id() == $user->id && $user->role == 1) {
            return back()->with('error', __('Operation denied.'));
        }

        $user->forceDelete();

        return redirect()->route('admin.users')->with('success', __(':name has been deleted.', ['name' => $user->name]));
    }

    /**
     * Soft delete the User
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function disableUser($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() == $user->id && $user->role == 1) {
            return back()->with('error', __('Operation denied.'));
        }

        $user->delete();

        return redirect()->route('admin.users.edit', $id)->with('success', __('Settings saved.'));
    }

    /**
     * Restore the soft deleted User
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restoreUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('admin.users.edit', $id)->with('success', __('Settings saved.'));
    }
    /**
     * Update a website model
     *
     * @param UpdateWebsiteRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateWebsite(UpdateWebsiteRequest $request, $id)
    {
        $website = Website::where('id', $id)->firstOrFail();

        $this->websiteUpdate($request, $website);

        return back()->with('success', __('Settings saved.'));
    }

    /**
     * Delete a website model
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteWebsite($id)
    {
        $website = Website::where('id', $id)->firstOrFail();
        $website->delete();

        $user = User::find($website->user_id);
        $user->has_websites = Website::where('user_id', '=', $user->id)->count() > 0;
        $user->save();

        return redirect()->route('admin.websites')->with('success', __(':name has been deleted.', ['name' => str_replace(['http://', 'https://'], '', $website->url)]));
    }

    /**
     * Validate and update the license
     *
     * @param UpdateSettingsLicenseRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateLicense(UpdateSettingsLicenseRequest $request)
    {
        $httpClient = new Client(['timeout' => 10/*, 'verify' => false*/]);

        try {
            $response = $httpClient->request('POST', 'https://api.lunatio.com/api/v1/license/validate',
                [
                    'form_params' => [
                        'license_id' => $request->input('license_key'),
                        'product_id' => 6,
                        'url' => env('APP_URL')
                    ]
                ]
            );

            $output = json_decode($response->getBody()->getContents());

            if ($output->status == 200) {
                Setting::where('name', '=', 'license_key')->update(['value' => $request->input('license_key')]);
                Setting::where('name', '=', 'license_type')->update(['value' => $output->type]);
            }

            return redirect()->route('admin.dashboard');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
