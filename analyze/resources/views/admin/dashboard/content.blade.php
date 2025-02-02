@extends('layouts.app')

@section('site_title', formatTitle([__('Dashboard'), config('settings.title')]))

@section('content')
<div class="bg-base-1 flex-fill">
    @include('admin.dashboard.header')
    <div class="bg-base-1">
        <div class="container py-3 my-3">
            <h4 class="mb-0">{{ __('Overview') }}</h4>

            <div class="row mb-5">
                @php
                    $cards = [
                        'users' =>
                        [
                            'title' => 'Users',
                            'value' => $stats['users'],
                            'description' => 'Manage users',
                            'route' => 'admin.users',
                            'icon' => 'icons.users'
                        ],
                        [
                            'title' => 'Subscriptions',
                            'value' => $stats['subscriptions'],
                            'description' => 'Manage subscriptions',
                            'route' => 'admin.subscriptions',
                            'icon' => 'icons.subscription'
                        ],
                        [
                            'title' => 'Plans',
                            'value' => $stats['plans'],
                            'description' => 'Manage plans',
                            'route' => 'admin.plans',
                            'icon' => 'icons.package'
                        ],
                        [
                            'title' => 'Pages',
                            'value' => $stats['pages'],
                            'description' => 'Manage pages',
                            'route' => 'admin.pages',
                            'icon' => 'icons.page'
                        ],
                        [
                            'title' => 'Websites',
                            'value' => $stats['websites'],
                            'description' => 'Manage websites',
                            'route' => 'admin.websites',
                            'icon' => 'icons.website'
                        ],
                        [
                            'title' => 'Cron jobs',
                            'value' => $stats['cronjobs'],
                            'description' => 'Manage cron jobs',
                            'route' => 'admin.settings.cronjob',
                            'icon' => 'icons.clock'
                        ]
                    ];
                @endphp

                @foreach($cards as $card)
                    <div class="col-12 col-md-6 col-lg-4 mt-3">
                        <div class="card border-0 shadow-sm h-100 overflow-hidden">
                            <div class="card-body d-flex">
                                <div class="flex-grow-1 d-block text-truncate">
                                    <div class="text-muted font-weight-medium mb-2 text-truncate">{{ __($card['title']) }}</div>
                                    <div class="h1 mb-0 font-weight-normal text-wrap">{{ number_format($card['value'], 0, __('.'), __(',')) }}</div>
                                </div>

                                <div class="d-flex position-relative text-primary width-10 height-10 align-items-center justify-content-center flex-shrink-0">
                                    <div class="position-absolute bg-primary opacity-10 top-0 right-0 bottom-0 left-0 border-radius-35"></div>
                                    @include($card['icon'], ['class' => 'fill-current width-5 height-5'])
                                </div>
                            </div>
                            <div class="card-footer bg-base-2 border-0">
                                <a href="{{ route($card['route']) }}" class="text-muted font-weight-medium d-inline-flex align-items-baseline">{{ __($card['description']) }}@include((__('lang_dir') == 'rtl' ? 'icons.chevron_left' : 'icons.chevron_right'), ['class' => 'width-3 height-3 fill-current '.(__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2')])</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <h4 class="mb-0">{{ __('Recent activity') }}</h4>
            <div class="row">
                <div class="col-12 col-xl-6 mt-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header align-items-center">
                            <div class="row">
                                <div class="col"><div class="font-weight-medium py-1">{{ __('Latest users') }}</div></div>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(count($users) == 0)
                                {{ __('No data') }}.
                            @else
                                <div class="list-group list-group-flush my-n3">
                                    @foreach($users as $user)
                                        <div class="list-group-item px-0">
                                            <div class="row align-items-center">
                                                <div class="col text-truncate">
                                                    <div class="text-truncate">
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ gravatar($user->email, 48) }}" class="rounded-circle width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                            <div class="text-truncate">
                                                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-truncate">{{ $user->name }}</a>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                            <div class="text-muted text-truncate small">
                                                                {{ $user->email }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6 mt-3">
                    @if(config('settings.stripe'))
                        <div class="card border-0 shadow-sm">
                            <div class="card-header align-items-center">
                                <div class="row">
                                    <div class="col"><div class="font-weight-medium py-1">{{ __('Latest subscriptions') }}</div></div>
                                </div>
                            </div>
                            <div class="card-body">
                                @if(count($subscriptions) == 0)
                                    {{ __('No data') }}.
                                @else
                                    <div class="list-group list-group-flush my-n3">
                                        @foreach($subscriptions as $subscription)
                                            <div class="list-group-item px-0">
                                                <div class="row align-items-center">
                                                    <div class="col text-truncate">
                                                        <div class="text-truncate">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ gravatar($subscription->user->email, 48) }}" class="rounded-circle width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">

                                                                <div class="text-truncate">
                                                                    <a href="{{ route('admin.users.edit', $subscription->user->id) }}">{{ $subscription->user->name }}</a>

                                                                    <div class="badge badge-{{ formatStripeStatus()[$subscription->stripe_status]['status'] }}">{{ formatStripeStatus()[$subscription->stripe_status]['title'] }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                                <div class="text-muted text-truncate small">
                                                                    <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}" class="text-secondary">{{ $subscription->name }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="{{ route('admin.subscriptions.edit', $subscription->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="card border-0 shadow-sm">
                            <div class="card-header align-items-center">
                                <div class="row">
                                    <div class="col"><div class="font-weight-medium py-1">{{ __('Latest websites') }}</div></div>
                                </div>
                            </div>

                            <div class="card-body">
                                @if(count($websites) == 0)
                                    {{ __('No data') }}.
                                @else
                                    <div class="list-group list-group-flush my-n3">
                                        @foreach($websites as $website)
                                            <div class="list-group-item px-0">
                                                <div class="row align-items-center">
                                                    <div class="col text-truncate">
                                                        <div class="text-truncate">
                                                            <div class="d-flex align-items-center">
                                                                <img src="https://icons.duckduckgo.com/ip3/{{ $website->url }}.ico" class="rounded-circle width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}" rel="noreferrer">

                                                                <div class="text-truncate">
                                                                    <a href="{{ route('admin.websites.edit', $website->id) }}">{{ $website->url }}</a>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="width-4 flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"></div>
                                                                <div class="text-muted text-truncate small">
                                                                    {{ $website->created_at->format(__('Y-m-d')) }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a href="{{ route('admin.websites.edit', $website->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('admin.sidebar')
@endsection