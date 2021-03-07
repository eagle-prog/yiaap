<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth Routes
Auth::routes(['verify' => true]);

// Install Routes
Route::prefix('install')->group(function () {
    Route::middleware('install')->group(function () {
        Route::get('/', 'InstallController@index')->name('install');
        Route::get('/requirements', 'InstallController@requirements')->name('install.requirements');
        Route::get('/permissions', 'InstallController@permissions')->name('install.permissions');
        Route::get('/database', 'InstallController@database')->name('install.database');
        Route::get('/account', 'InstallController@account')->name('install.account');

        Route::post('/database', 'InstallController@saveConfig');
        Route::post('/account', 'InstallController@saveDatabase');
    });

    Route::get('/complete', 'InstallController@complete')->name('install.complete');
});

// Update Routes
Route::prefix('update')->group(function () {
    Route::middleware('installed')->group(function () {
        Route::get('/', 'UpdateController@index')->name('update');
        Route::get('/overview', 'UpdateController@overview')->name('update.overview');
        Route::get('/complete', 'UpdateController@complete')->name('update.complete');

        Route::post('/overview', 'UpdateController@updateDatabase');
    });
});

// Language Routes
Route::post('/lang', 'LocaleController@index')->name('locale');

// Home Routes
Route::get('/', 'HomeController@index')->middleware('installed')->name('home');

// Contact Routes
Route::get('/contact', 'ContactController@index')->name('contact');
Route::post('/contact', 'ContactController@sendMail')->middleware('throttle:5,10');

// Pages Routes
Route::get('/page/{url}', 'PageController@index')->name('page');

// Developers Routes
Route::prefix('/developers')->group(function () {
    Route::get('/', 'DevelopersController@index')->name('developers');
    Route::get('/stats', 'DevelopersController@stats')->name('developers.stats');
    Route::get('/websites', 'DevelopersController@websites')->name('developers.websites');
    Route::get('/account', 'DevelopersController@account')->name('developers.account');
});

// User Routes
Route::get('/dashboard', 'DashboardController@index')->middleware('verified')->name('dashboard');

// Websites Routes
Route::get('/websites', 'WebsitesController@index')->middleware('verified')->name('websites');
Route::get('/websites/new', 'WebsitesController@websitesNew')->middleware('verified')->name('websites.new');
Route::get('/websites/edit/{id}', 'WebsitesController@websitesEdit')->middleware('verified')->name('websites.edit');

Route::post('/websites/new', 'WebsitesController@createWebsite');
Route::post('/websites/edit/{id}', 'WebsitesController@updateWebsite');
Route::post('/websites/delete/{id}', 'WebsitesController@deleteWebsite')->name('websites.delete');

Route::prefix('settings')->middleware('verified')->group(function () {
    Route::get('/', 'SettingsController@index')->name('settings');

    Route::get('/account', 'SettingsController@account')->name('settings.account');
    Route::get('/security', 'SettingsController@security')->name('settings.security');
    Route::get('/api', 'SettingsController@api')->name('settings.api');
    Route::get('/delete', 'SettingsController@delete')->name('settings.delete');

    Route::get('/payments/methods', 'SettingsController@paymentMethods')->middleware('payment')->name('settings.payments.methods');
    Route::get('/payments/methods/new', 'SettingsController@paymentMethodsNew')->middleware('payment')->name('settings.payments.methods.new');
    Route::get('/payments/methods/edit/{id}', 'SettingsController@paymentMethodsEdit')->middleware('payment')->name('settings.payments.methods.edit');

    Route::get('/payments/subscriptions', 'SettingsController@subscriptions')->middleware('payment')->name('settings.payments.subscriptions');
    Route::get('/payments/subscriptions/edit/{id}', 'SettingsController@subscriptionsEdit')->middleware('payment')->name('settings.payments.subscriptions.edit');

    Route::get('/payments/invoices', 'SettingsController@invoices')->middleware('payment')->name('settings.payments.invoices');
    Route::get('/payments/invoice/{invoice}', 'SettingsController@invoice')->middleware('payment')->name('settings.payments.invoice');

    Route::get('/payments/billing', 'SettingsController@billing')->middleware('payment')->name('settings.payments.billing');

    Route::post('/account', 'SettingsController@updateAccount')->name('settings.account.update');
    Route::post('/account/resend', 'SettingsController@resendAccount')->name('settings.account.resend');
    Route::post('/account/cancel', 'SettingsController@cancelAccount')->name('settings.account.cancel');
    Route::post('/security', 'SettingsController@updateSecurity')->name('settings.security.update');
    Route::post('/delete', 'SettingsController@deleteAccount')->name('settings.account.delete');

    Route::post('/payments/methods/new', 'SettingsController@createPaymentMethod')->middleware('payment');
    Route::post('/payments/methods/edit/{id}', 'SettingsController@updatePaymentMethod')->middleware('payment');
    Route::post('/payments/methods/delete/{id}', 'SettingsController@deletePaymentMethod')->middleware('payment')->name('settings.payments.methods.delete');

    Route::post('/payments/subscriptions/cancel/{subscription}', 'SettingsController@cancelSubscription')->middleware('payment')->name('settings.payments.subscriptions.cancel');
    Route::post('/payments/subscriptions/resume/{subscription}', 'SettingsController@resumeSubscription')->middleware('payment')->name('settings.payments.subscriptions.resume');

    Route::post('/payments/billing', 'SettingsController@updateBilling')->middleware('payment');

    Route::post('/api', 'SettingsController@updateApi')->name('settings.api.update');
});

// Admin Routes
Route::prefix('admin')->middleware('admin', 'license')->group(function () {
    Route::redirect('/', 'admin/dashboard');

    Route::get('/dashboard', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/settings/general', 'AdminController@settingsGeneral')->name('admin.settings.general');
    Route::get('/settings/appearance', 'AdminController@settingsAppearance')->name('admin.settings.appearance');
    Route::get('/settings/email', 'AdminController@settingsEmail')->name('admin.settings.email');
    Route::get('/settings/social', 'AdminController@settingsSocial')->name('admin.settings.social');
    Route::get('/settings/payment', 'AdminController@settingsPayment')->name('admin.settings.payment');
    Route::get('/settings/invoice', 'AdminController@settingsInvoice')->name('admin.settings.invoice');
    Route::get('/settings/registration', 'AdminController@settingsRegistration')->name('admin.settings.registration');
    Route::get('/settings/contact', 'AdminController@settingsContact')->name('admin.settings.contact');
    Route::get('/settings/legal', 'AdminController@settingsLegal')->name('admin.settings.legal');
    Route::get('/settings/captcha', 'AdminController@settingsCaptcha')->name('admin.settings.captcha');
    Route::get('/settings/cronjob', 'AdminController@settingsCronjob')->name('admin.settings.cronjob');
    Route::get('/settings/analytics', 'AdminController@settingsAnalytics')->name('admin.settings.analytics');

    Route::get('/languages', 'AdminController@languages')->name('admin.languages');
    Route::get('/languages/new', 'AdminController@languagesNew')->name('admin.languages.new');
    Route::get('/languages/edit/{id}', 'AdminController@languagesEdit')->name('admin.languages.edit');

    Route::get('/users', 'AdminController@users')->name('admin.users');
    Route::get('/users/new', 'AdminController@usersNew')->name('admin.users.new');
    Route::get('/users/edit/{id}', 'AdminController@usersEdit')->name('admin.users.edit');

    Route::get('/pages', 'AdminController@pages')->name('admin.pages');
    Route::get('/pages/new', 'AdminController@pagesNew')->name('admin.pages.new');
    Route::get('/pages/edit/{id}', 'AdminController@pagesEdit')->name('admin.pages.edit');

    Route::get('/plans', 'AdminController@plans')->name('admin.plans');
    Route::get('/plans/new', 'AdminController@plansNew')->middleware('payment')->name('admin.plans.new');
    Route::get('/plans/edit/{id}', 'AdminController@plansEdit')->name('admin.plans.edit');

    Route::get('/subscriptions', 'AdminController@subscriptions')->name('admin.subscriptions');
    Route::get('/subscriptions/new', 'AdminController@subscriptionsNew')->middleware('payment')->name('admin.subscriptions.new');
    Route::get('/subscriptions/edit/{id}', 'AdminController@subscriptionsEdit')->name('admin.subscriptions.edit');

    Route::get('/websites', 'AdminController@websites')->name('admin.websites');
    Route::get('/websites/edit/{id}', 'AdminController@websitesEdit')->name('admin.websites.edit');


    Route::post('/settings/general', 'AdminController@updateSettingsGeneral');
    Route::post('/settings/appearance', 'AdminController@updateSettingsAppearance');
    Route::post('/settings/email', 'AdminController@updateSettingsEmail');
    Route::post('/settings/social', 'AdminController@updateSettingsSocial');
    Route::post('/settings/payment', 'AdminController@updateSettingsPayment');
    Route::post('/settings/invoice', 'AdminController@updateSettingsInvoice');
    Route::post('/settings/registration', 'AdminController@updateSettingsRegistration');
    Route::post('/settings/contact', 'AdminController@updateSettingsContact');
    Route::post('/settings/legal', 'AdminController@updateSettingsLegal');
    Route::post('/settings/captcha', 'AdminController@updateSettingsCaptcha');
    Route::post('/settings/cronjob', 'AdminController@updateSettingsCronjob');
    Route::post('/settings/analytics', 'AdminController@updateSettingsAnalytics');

    Route::post('/languages/new', 'AdminController@createLanguage');
    Route::post('/languages/edit/{id}', 'AdminController@updateLanguage');
    Route::post('/language/delete/{id}', 'AdminController@deleteLanguage')->name('admin.languages.delete');

    Route::post('/users/new', 'AdminController@createUser');
    Route::post('/users/edit/{id}', 'AdminController@updateUser');
    Route::post('/users/delete/{id}', 'AdminController@deleteUser')->name('admin.users.delete');
    Route::post('/users/disable/{id}', 'AdminController@disableUser')->name('admin.users.disable');
    Route::post('/users/restore/{id}', 'AdminController@restoreUser')->name('admin.users.restore');

    Route::post('/pages/new', 'AdminController@createPage');
    Route::post('/pages/edit/{id}', 'AdminController@updatePage');
    Route::post('/pages/delete/{id}', 'AdminController@deletePage')->name('admin.pages.delete');

    Route::post('/plans/new', 'AdminController@createPlan')->middleware('payment');
    Route::post('/plans/edit/{id}', 'AdminController@updatePlan');
    Route::post('/plans/disable/{id}', 'AdminController@disablePlan')->middleware('payment')->name('admin.plans.disable');
    Route::post('/plans/restore/{id}', 'AdminController@restorePlan')->middleware('payment')->name('admin.plans.restore');

    Route::post('/subscriptions/new', 'AdminController@createSubscription')->middleware('payment');
    Route::post('/subscriptions/delete/{id}', 'AdminController@deleteSubscription')->name('admin.subscriptions.delete');

    Route::post('/websites/edit/{id}', 'AdminController@updateWebsite');
    Route::post('/websites/delete/{id}', 'AdminController@deleteWebsite')->name('admin.websites.delete');
});

Route::get('admin/license', 'AdminController@license')->middleware('admin')->name('admin.license');
Route::post('admin/license', 'AdminController@updateLicense')->middleware('admin');

// Pricing Routes
Route::prefix('pricing')->middleware('payment')->group(function () {
    Route::get('/', 'PricingController@index')->name('pricing');
});

// Checkout Routes
Route::prefix('checkout')->middleware('verified', 'payment')->group(function () {
    Route::get('/collect/{period}', 'CheckoutController@collect')->name('checkout.collect');
    Route::post('/collect/{period}', 'CheckoutController@updatePaymentDetails');

    Route::get('/confirm/{id}', 'CheckoutController@show')->name('checkout.confirm');

    Route::get('/cancelled', 'CheckoutController@cancelled')->name('checkout.cancelled');
    Route::get('/complete', 'CheckoutController@complete')->name('checkout.complete');

    Route::get('/{id}/{period}', 'CheckoutController@index')->name('checkout.index');
    Route::post('/subscribe/{id}/{period}', 'CheckoutController@subscribe')->name('checkout.subscribe');
});

// Stripe Webhook Routes
Route::post('stripe/webhook', 'WebhookController@handleWebhook')->name('stripe.webhook');

Route::prefix('/{id}')->group(function () {
    Route::get('/', 'StatsController@index')->name('stats.overview');

    Route::get('/realtime', 'StatsController@realTime')->name('stats.realtime');

    Route::get('/pages', 'StatsController@pages')->name('stats.pages');
    Route::get('/landing_pages', 'StatsController@landingPages')->name('stats.landing-pages');

    Route::get('/referrers', 'StatsController@referrers')->name('stats.referrers');
    Route::get('/search-engines', 'StatsController@searchEngines')->name('stats.search-engines');
    Route::get('/social-networks', 'StatsController@socialNetworks')->name('stats.social-networks');
    Route::get('/campaigns', 'StatsController@campaigns')->name('stats.campaigns');

    Route::get('/continents', 'StatsController@continents')->name('stats.continents');
    Route::get('/countries', 'StatsController@countries')->name('stats.countries');
    Route::get('/cities', 'StatsController@cities')->name('stats.cities');
    Route::get('/languages', 'StatsController@languages')->name('stats.languages');

    Route::get('/browsers', 'StatsController@browsers')->name('stats.browsers');
    Route::get('/operating-systems', 'StatsController@operatingSystems')->name('stats.operating-systems');
    Route::get('/screen-resolutions', 'StatsController@screenResolutions')->name('stats.screen-resolutions');
    Route::get('/devices', 'StatsController@devices')->name('stats.devices');

    Route::get('/events', 'StatsController@events')->name('stats.events');

    Route::prefix('/export')->group(function () {
        Route::get('/pages', 'StatsController@exportPages')->name('stats.export.pages');
        Route::get('/landing_pages', 'StatsController@exportLandingPages')->name('stats.export.landing-pages');

        Route::get('/referrers', 'StatsController@exportReferrers')->name('stats.export.referrers');
        Route::get('/search-engines', 'StatsController@exportSearchEngines')->name('stats.export.search-engines');
        Route::get('/social-networks', 'StatsController@exportSocialNetworks')->name('stats.export.social-networks');
        Route::get('/campaigns', 'StatsController@exportCampaigns')->name('stats.export.campaigns');

        Route::get('/continents', 'StatsController@exportContinents')->name('stats.export.continents');
        Route::get('/countries', 'StatsController@exportCountries')->name('stats.export.countries');
        Route::get('/cities', 'StatsController@exportCities')->name('stats.export.cities');
        Route::get('/languages', 'StatsController@exportLanguages')->name('stats.export.languages');

        Route::get('/browsers', 'StatsController@exportBrowsers')->name('stats.export.browsers');
        Route::get('/operating-systems', 'StatsController@exportOperatingSystems')->name('stats.export.operating-systems');
        Route::get('/screen-resolutions', 'StatsController@exportScreenResolutions')->name('stats.export.screen-resolutions');
        Route::get('/devices', 'StatsController@exportDevices')->name('stats.export.devices');

        Route::get('/events', 'StatsController@exportEvents')->name('stats.export.events');
    });

    Route::post('/password', 'StatsController@validatePassword')->name('stats.password');
});

Route::prefix('cronjob')->middleware('cronjob')->group(function () {
    Route::get('email', 'CronjobController@email')->name('cronjob.email');
    Route::get('check', 'CronjobController@check')->name('cronjob.check');
    Route::get('clean', 'CronjobController@clean')->name('cronjob.clean');
});