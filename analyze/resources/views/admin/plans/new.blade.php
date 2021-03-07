@section('site_title', formatTitle([__('New'), __('Plan'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['url' => route('admin.plans'), 'title' => __('Plans')],
    ['title' => __('New')],
]])

<h2 class="mb-3 d-inline-block">{{ __('New') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header"><div class="font-weight-medium py-1">{{ __('Plan') }}</div></div>
    <div class="card-body">
        @include('shared.message')

        <form action="{{ route('admin.plans.new') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="i_name">{{ __('Name') }}</label>
                <input type="text" name="name" id="i_name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i_description">{{ __('Description') }}</label>
                <input type="text" name="description" id="i_description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" value="{{ old('description') }}">
                @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i_trial_days">{{ __('Trial days') }}</label>
                <input type="number" name="trial_days" id="i_trial_days" class="form-control{{ $errors->has('trial_days') ? ' is-invalid' : '' }}" value="{{ old('trial_days') ?? 0 }}">
                @if ($errors->has('trial_days'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('trial_days') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i_currency">{{ __('Currency') }}</label>
                <select name="currency" id="i_currency" class="custom-select{{ $errors->has('currency') ? ' is-invalid' : '' }}">
                    @foreach(config('currencies.stripe.all') as $key => $value)
                        <option value="{{ $key }}" @if(old('currency') == $key) selected @endif>{{ $key }} - {{ $value }}</option>
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
                        <input type="number" name="amount_month" id="i_amount_month" class="form-control{{ $errors->has('amount_month') ? ' is-invalid' : '' }}" value="{{ old('amount_month') }}">
                        @if ($errors->has('amount_month'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('amount_month') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col col-lg-6">
                    <div class="form-group">
                        <label for="i_amount_year" class="d-flex align-items-center">{{ __('Yearly amount') }} <a href="https://stripe.com/docs/currencies#zero-decimal" class="d-flex align-content-center {{ (__('lang_dir') == 'rtl' ? 'mr-2' : 'ml-2') }}" data-enable="tooltip" title="{{ __('Learn more') }}" target="_blank">@include('icons.info', ['class' => 'text-muted width-4 height-4 fill-current'])</a></label>
                        <input type="number" name="amount_year" id="i_amount_year" class="form-control{{ $errors->has('amount_year') ? ' is-invalid' : '' }}" value="{{ old('amount_year') }}">
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
                <textarea name="coupons" id="i_coupons" class="form-control{{ $errors->has('coupons') ? ' is-invalid' : '' }}" placeholder="{{ __('One per line.') }}">{{ old('coupons') }}</textarea>
                @if ($errors->has('coupons'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('coupons') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                <label for="i_visibility">{{ __('Visibility') }}</label>
                <select name="visibility" id="i_visibility" class="custom-select{{ $errors->has('public') ? ' is-invalid' : '' }}">
                    @foreach([1 => __('Public'), 0 => __('Private')] as $key => $value)
                        <option value="{{ $key }}" @if(old('visibility') == $key && old('visibility') !== null) selected @endif>{{ $value }}</option>
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
                <input type="number" name="option_pageviews" id="i_option_pageviews" class="form-control{{ $errors->has('option_pageviews') ? ' is-invalid' : '' }}" value="{{ old('option_pageviews') ?? 0 }}">
                @if ($errors->has('option_pageviews'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('option_pageviews') }}</strong>
                    </span>
                @endif
            </div>

            <button type="submit" name="submit" class="btn btn-primary">{{ __('Save') }}</button>
        </form>
    </div>
</div>