<div class="card border-0 shadow-sm mt-5 mb-3">
    <div class="card-body p-4 p-md-5">
        <div class="row mb-3">
            <div class="col-12 col-md order-1 order-md-0 text-center {{ (__('lang_dir') == 'rtl' ? 'text-md-right' : 'text-md-left') }} mt-4 mt-md-0">
                <div class="text-uppercase font-weight-bold text-muted small mb-2">{{ __('Monthly pageviews') }}</div>
                @foreach($plans as $plan)
                    <div class="plan-toggle plan-toggle{{ $loop->index }} @if($loop->index != 0) d-none @endif">
                        <div class="plan-preload plan-monthly d-none d-block">
                            <div class="h3 font-weight-bold">
                                {{ shortenNumber($plan->option_pageviews) }}
                            </div>
                        </div>

                        <div class="plan-yearly d-none">
                            <div class="h3 font-weight-bold">
                                {{ shortenNumber($plan->option_pageviews) }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-12 col-md order-0 order-md-1 mt-4 mt-md-0">
                <div class="mb-3 text-center">
                    <div class="text-uppercase font-weight-bold text-muted small mb-2">{{ __('Billing') }}</div>

                    <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-dark active" id="plan-monthly">
                            <input type="radio" name="options" autocomplete="off" checked>{{ __('Monthly') }}
                        </label>
                        <label class="btn btn-outline-dark" id="plan-yearly">
                            <input type="radio" name="options" autocomplete="off">{{ __('Yearly') }}
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md order-2 order-md-2 text-center {{ (__('lang_dir') == 'rtl' ? 'text-md-left' : 'text-md-right') }} mt-4 mt-md-0">
                <div class="d-flex flex-row-reverse flex-md-row justify-content-center justify-content-md-end">
                    @foreach($plans as $plan)
                        <div class="plan-toggle plan-toggle{{ $loop->index }} @if($loop->index != 0) d-none @endif">
                            @if($plan->plan_month && $plan->plan_year)
                                <div class="plan-yearly d-none">
                                    @if(($plan->amount_month*12) > $plan->amount_year)
                                        <div class="d-flex">
                                            <span class="badge badge-success mx-2 mb-2">
                                                {{ __(':value% off', ['value' => number_format(((($plan->amount_month*12) - $plan->amount_year)/($plan->amount_month*12) * 100), 0)]) }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach

                    <div class="text-uppercase font-weight-bold text-muted small mb-2">{{ __('Price') }}</div>
                </div>

                @foreach($plans as $plan)
                    <div class="plan-toggle plan-toggle{{ $loop->index }} @if($loop->index != 0) d-none @endif">
                        @if($plan->plan_month && $plan->plan_year)
                            <div class="plan-preload plan-monthly d-none d-block">
                                <div class="h3 font-weight-bold mb-1">
                                    <span class="font-weight-bold">
                                        {{ formatMoney($plan->amount_month, $plan->currency) }}
                                    </span>
                                    <span class="pricing-plan-price text-muted">
                                        {{ $plan->currency }}
                                    </span>
                                </div>
                            </div>

                            <div class="plan-yearly d-none">
                                <div class="h3 font-weight-bold mb-1">
                                    <span class="font-weight-bold">
                                        {{ formatMoney($plan->amount_year, $plan->currency) }}
                                    </span>
                                    <span class="pricing-plan-price text-muted">
                                        {{ $plan->currency }}
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="plan-preload plan-monthly d-none d-block">
                                <div class="h3 font-weight-bold mb-1">
                                    <span class="font-weight-bold">
                                        {{ __('Free') }}
                                    </span>
                                </div>
                            </div>

                            <div class="plan-yearly d-none">
                                <div class="h3 font-weight-bold mb-1">
                                    <span class="font-weight-bold">
                                        {{ __('Free') }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <input type="range" class="custom-range" id="current-plan" min="0" max="{{ (count($plans)-1) }}" value="0">

        <div class="text-uppercase font-weight-bold small mt-3 text-primary">{{ __('What\'s included') }}</div>

        <div class="row">
            @foreach(['Unlimited websites', 'Unlimited events', 'API access', 'Email reports', 'Data ownership', 'Data export'] as $feature)
                <div class="col-12 col-md-6 col-lg-4 d-flex align-items-center mt-3">
                    <div class="d-flex position-relative text-success width-5 height-5 align-items-center justify-content-center flex-shrink-0 {{ (__('lang_dir') == 'rtl' ? 'ml-2' : 'mr-2') }}">
                        <div class="position-absolute bg-success opacity-10 top-0 right-0 bottom-0 left-0 rounded-circle"></div>
                        @include('icons.checkmark', ['class' => 'fill-current width-3 height-3'])
                    </div>
                    <div class="text-muted">{{ __($feature) }}</div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="d-flex justify-content-center">
    @foreach($plans as $plan)
        <div class="mt-3 mx-2 plan-toggle plan-toggle{{ $loop->index }} @if($loop->index != 0) d-none @endif">
            @auth
                @if($plan->plan_month && $plan->plan_year)
                    @if($user->subscribed($plan->name))
                        <div class="btn btn-lg btn-primary font-size-lg disabled">{{ __('Active') }}</div>
                    @else
                        <div class="plan-no-animation plan-monthly d-none d-block">
                            <a href="{{ route('checkout.index', ['id' => $plan->id, 'period' => 'monthly']) }}" class="btn btn-lg btn-primary font-size-lg">
                                @if($plan->trial_days > 0)
                                    {{ __('Free trial') }}
                                @else
                                    @if($user->hasIncompletePayment($plan->name))
                                        {{ __('Confirm payment') }}
                                    @else
                                        {{ __('Subscribe') }}
                                    @endif
                                @endif
                            </a>
                        </div>
                        <div class="plan-no-animation plan-yearly d-none">
                            <a href="{{ route('checkout.index', ['id' => $plan->id, 'period' => 'yearly']) }}" class="btn btn-lg btn-primary font-size-lg">
                                @if($plan->trial_days > 0)
                                    {{ __('Free trial') }}
                                @else
                                    @if($user->hasIncompletePayment($plan->name))
                                        {{ __('Confirm payment') }}
                                    @else
                                        {{ __('Subscribe') }}
                                    @endif
                                @endif
                            </a>
                        </div>
                    @endif
                @else
                    <div class="btn btn-lg btn-primary font-size-lg disabled">{{ __('Free') }}</div>
                @endif
            @else
                @if(config('settings.registration_registration'))
                    <div class="plan-no-animation plan-monthly d-none d-block">
                        <a href="{{ route('register', ['plan' => $plan->id, 'period' => 'monthly']) }}" class="btn btn-lg btn-primary font-size-lg">{{ __('Get started') }}</a>
                    </div>
                    <div class="plan-no-animation plan-yearly d-none">
                        <a href="{{ route('register', ['plan' => $plan->id, 'period' => 'yearly']) }}" class="btn btn-lg btn-primary font-size-lg">{{ __('Get started') }}</a>
                    </div>
                @else
                    <div class="plan-no-animation plan-monthly d-none d-block">
                        <a href="{{ route('login', ['plan' => $plan->id, 'period' => 'monthly']) }}" class="btn btn-lg btn-primary font-size-lg">{{ __('Get started') }}</a>
                    </div>
                    <div class="plan-no-animation plan-yearly d-none">
                        <a href="{{ route('login', ['plan' => $plan->id, 'period' => 'yearly']) }}" class="btn btn-lg btn-primary font-size-lg">{{ __('Get started') }}</a>
                    </div>
                @endif
            @endauth
        </div>
    @endforeach
</div>