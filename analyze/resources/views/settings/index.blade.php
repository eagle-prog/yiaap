@section('site_title', formatTitle([__('Settings'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('dashboard'), 'title' => __('Home')],
    ['title' => __('Settings')]
]])

<h2 class="mb-0 d-inline-block">{{ __('Settings') }}</h2>

@php
    $settings = [
        [
            'icon' => 'icons.account',
            'title' => 'Account',
            'description' => 'Update your account information',
            'route' => 'settings.account'
        ],
        [
            'icon' => 'icons.security',
            'title' => 'Security',
            'description' => 'Change your security information',
            'route' => 'settings.security'
        ],
        [
            'icon' => 'icons.card',
            'title' => 'Payment methods',
            'description' => 'Add, change, or remove payment methods',
            'route' => 'settings.payments.methods'
        ],
        [
            'icon' => 'icons.billing',
            'title' => 'Billing information',
            'description' => 'Change your billing information',
            'route' => 'settings.payments.billing'
        ],
        [
            'icon' => 'icons.subscription',
            'title' => 'Subscriptions',
            'description' => 'View your subscriptions details',
            'route' => 'settings.payments.subscriptions'
        ],
        [
            'icon' => 'icons.invoice',
            'title' => 'Invoices',
            'description' => 'Print and view your invoice history',
            'route' => 'settings.payments.invoices'
        ],
        [
            'icon' => 'icons.api',
            'title' => 'API',
            'description' => 'View and change your developer key',
            'route' => 'settings.api'
        ],
        [
            'icon' => 'icons.delete',
            'title' => 'Delete account',
            'description' => 'Delete your account and associated data',
            'route' => 'settings.delete'
        ]
    ];
@endphp

<div class="row">
    @foreach($settings as $setting)
        @if(strpos($setting['route'], '.payments.') == false || (strpos($setting['route'], '.payments.') == true && config('settings.stripe')))
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 mt-3">
                <div class="card border-0 h-100 shadow-sm">
                    <div class="card-body d-flex flex-column text-center">
                        <div class="d-flex position-relative text-primary width-12 height-12 align-items-center justify-content-center my-3 mx-auto">
                            <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                            @include($setting['icon'], ['class' => 'fill-current width-6 height-6'])
                        </div>

                        <div class="my-2 text-dark font-weight-medium font-size-lg">{{ __($setting['title']) }}</div>

                        <a href="{{ (Route::has($setting['route']) ? route($setting['route']) : $setting['route']) }}" class="text-secondary text-decoration-none stretched-link mb-3">
                            {{ __($setting['description']) }}
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
