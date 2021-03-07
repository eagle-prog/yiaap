@section('site_title', formatTitle([__('Edit'), __('Plan'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['url' => route('admin.plans'), 'title' => __('Plans')],
    ['title' => __('Edit')],
]])

<h2 class="mb-3 d-inline-block">{{ __('Edit') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col">
                <div class="font-weight-medium py-1">{{ __('Plan') }}</div>
            </div>
            <div class="col-auto">
                @if($plan->amount_month && $plan->amount_year)<a href="{{ route('checkout.index', ['id' => $plan->id, 'period' => 'monthly']) }}" class="btn btn-outline-primary btn-sm @if($plan->trashed()) disabled @endif">{{ __('View') }}</a>@endif
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        @if($plan->trashed())
            <div class="alert alert-danger" role="alert">
                {{ __(':name is disabled.', ['name' => $plan->name]) }}
            </div>
        @endif

        <form action="{{ route('admin.plans.edit', $plan->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i_name">{{ __('Name') }}</label>
                <input type="text" name="name" id="i_name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ $plan->name }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i_description">{{ __('Description') }}</label>
                <input type="text" name="description" id="i_description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ $plan->description }}">
                @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>

            @if($plan->amount_month && $plan->amount_year)
                <div class="form-group">
                    <label for="i_trial_days">{{ __('Trial days') }}</label>
                    <input type="number" name="trial_days" id="i_trial_days" class="form-control{{ $errors->has('trial_days') ? ' is-invalid' : '' }}" value="{{ $plan->trial_days }}">
                    @if ($errors->has('trial_days'))
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('trial_days') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="i_currency">{{ __('Currency') }}</label>
                    <select name="currency" id="i_currency" class="custom-select{{ $errors->has('currency') ? ' is-invalid' : '' }}" disabled>
                        @foreach(config('currencies.stripe.all') as $key => $value)
                            <option value="{{ $key }}" @if((old('currency') !== null && old('currency') == $key) || ($plan->currency == $key && old('currency') == null)) selected @endif>{{ $key }} - {{ $value }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('currency'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('currency') }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-row">
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="i_amount_month" class="d-flex align-items-center">{{ __('Monthly amount') }} <a href="https://stripe.com/docs/currencies#zero-decimal" class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Learn more') }}" target="_blank">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</a></label>
                            <input type="number" name="amount_month" id="i_amount_month" class="form-control{{ $errors->has('amount_month') ? ' is-invalid' : '' }}" value="{{ old('amount_month') ?? $plan->amount_month }}" disabled>
                            @if ($errors->has('amount_month'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount_month') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="form-group">
                            <label for="i_amount_year" class="d-flex align-items-center">{{ __('Yearly amount') }} <a href="https://stripe.com/docs/currencies#zero-decimal" class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Learn more') }}" target="_blank">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</a></label>
                            <input type="number" name="amount_year" id="i_amount_year" class="form-control{{ $errors->has('amount_year') ? ' is-invalid' : '' }}" value="{{ old('amount_year') ?? $plan->amount_year }}" disabled>
                            @if ($errors->has('amount_year'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('amount_year') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="i_coupons">{{ __('Coupons') }}</label>
                    <textarea name="coupons" id="i_coupons" class="form-control{{ $errors->has('coupons') ? ' is-invalid' : '' }}" placeholder="{{ __('One per line.') }}">{{ old('coupons') ?? $plan->coupons }}</textarea>
                    @if ($errors->has('coupons'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('coupons') }}</strong>
                        </span>
                    @endif
                </div>
            @endif

            <div class="form-group">
                <label for="i_visibility">{{ __('Visibility') }}</label>
                <select name="visibility" id="i_visibility" class="custom-select{{ $errors->has('visibility') ? ' is-invalid' : '' }}">
                    @foreach([1 => __('Public'), 0 => __('Private')] as $key => $value)
                        <option value="{{ $key }}" @if((old('visibility') !== null && old('visibility') == $key) || ($plan->visibility == $key && old('visibility') == null)) selected @endif>{{ $value }}</option>
                    @endforeach
                </select>
                @if ($errors->has('visibility'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('visibility') }}</strong>
                    </span>
                @endif
            </div>

            <div class="hr-text"><span class="font-weight-medium text-muted">{{ __('Features') }}</span></div>

            <div class="form-group">
                <label for="i_option_pageviews">{{ __('Pageviews') }}</label>
                <input type="number" name="option_pageviews" id="i_option_pageviews" class="form-control{{ $errors->has('option_pageviews') ? ' is-invalid' : '' }}" value="{{ old('option_pageviews') ?? $plan->option_pageviews }}">
                @if ($errors->has('option_pageviews'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('option_pageviews') }}</strong>
                    </span>
                @endif
            </div>

            <div class="row mt-3">
                <div class="col">
                    <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
                </div>
                <div class="col-auto">
                    @if($plan->trashed())
                        <button type="button" class="btn btn-outline-success" data-toggle="modal" data-target="#restoreModal">{{ __('Restore') }}</button>
                    @else
                        <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#deleteModal">{{ __('Disable') }}</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">{{ __('Disable') }}</h6>
                <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                </button>
            </div>
            <div class="modal-body">
                {{ __('Are you sure you want to disable :name?', ['name' => $plan->name]) }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.plans.disable', $plan->id) }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-danger">{{ __('Disable') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="restoreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">{{ __('Restore') }}</h6>
                <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                </button>
            </div>
            <div class="modal-body">
                <div>{{ __('Are you sure you want to restore :name?', ['name' => $plan->name]) }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.plans.restore', $plan->id) }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-success">{{ __('Restore') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>