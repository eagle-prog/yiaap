@section('site_title', formatTitle([__('Websites'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Websites')],
]])

<div class="d-flex">
    <div class="flex-grow-1">
        <h2 class="mb-3 d-inline-block">{{ __('Websites') }}</h2>
    </div>
    <div>
        <a href="{{ route('websites.new') }}" class="btn btn-primary mb-3">{{ __('New') }}</a>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header">
        <div class="row">
            <div class="col-12 col-md"><div class="font-weight-medium py-1">{{ __('Websites') }}</div></div>
            <div class="col-12 col-md-auto">
                <form method="GET" action="{{ route('admin.websites') }}" class="d-md-flex">
                    @include('shared.filter_tags')
                    <div class="input-group input-group-sm">
                        <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn {{ request()->input('sort') ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                            <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64" id="search-filters">
                                <div class="dropdown-header py-1">
                                    <div class="row">
                                        <div class="col"><div class="font-weight-medium m-0 text-dark text-truncate">{{ __('Filters') }}</div></div>
                                        <div class="col-auto">
                                            @if(request()->input('sort'))
                                                <a href="{{ route('admin.websites') }}" class="text-secondary">{{ __('Reset') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="dropdown-divider"></div>

                                <div class="form-group px-4">
                                    <label for="i_sort" class="small">{{ __('Sort') }}</label>
                                    <select name="sort" id="i_sort" class="custom-select custom-select-sm">
                                        @foreach(['desc' => __('Descending'), 'asc' => __('Ascending')] as $key => $value)
                                            <option value="{{ $key }}" @if(request()->input('sort') == $key) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group px-4 mb-2">
                                    <button type="submit" class="btn btn-primary btn-sm btn-block">{{ __('Search') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        @if(count($websites) == 0)
            {{ __('No data') }}.
        @else
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0 text-muted">
                    <div class="row d-flex align-items-center">
                        <div class="col">
                            <div class="row align-items-center">
                                <div class="col-12 col-lg-6 text-truncate">
                                    {{ __('Name') }}
                                </div>

                                <div class="col-12 col-lg-6 text-truncate">
                                    {{ __('User') }}
                                </div>
                            </div>
                        </div>
                        <div class="col-auto d-flex align-items-center">
                            <a href="#" class="btn btn-outline-primary btn-sm invisible">{{ __('Edit') }}</a>
                        </div>
                    </div>
                </div>

                @foreach($websites as $website)
                    <div class="list-group-item px-0">
                        <div class="row d-flex align-items-center">
                            <div class="col text-truncate">
                                <div class="row text-truncate">
                                    <div class="col-12 col-lg-6 d-flex align-items-center text-truncate">
                                        <img src="https://icons.duckduckgo.com/ip3/{{ $website->url }}.ico" rel="noreferrer" class="width-4 height-4 {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}"> <div class="text-truncate" dir="ltr"><a href="{{ route('admin.websites.edit', $website->id) }}">{{ $website->url }}</a></div>
                                    </div>

                                    <div class="col-12 col-lg-5 d-flex align-items-center">
                                        <div class="d-inline-block {{ (__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3') }}">
                                            <img src="{{ gravatar($website->user->email, 48) }}" class="rounded-circle width-6 height-6">
                                        </div>
                                        <a href="{{ route('admin.users.edit', $website->user->id) }}">{{ $website->user->name }}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto d-flex align-items-center">
                                <a href="{{ route('admin.websites.edit', $website->id) }}" class="btn btn-outline-primary btn-sm">{{ __('Edit') }}</a>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3 align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $websites->firstItem(), 'to' => $websites->lastItem(), 'total' => $websites->total()]) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            {{ $websites->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>