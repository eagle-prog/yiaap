@section('site_title', formatTitle([__('Settings'), config('settings.title')]))

@include('shared.breadcrumbs', ['breadcrumbs' => [
    ['url' => route('admin.dashboard'), 'title' => __('Admin')],
    ['title' => __('Settings')],
]])

<h2 class="mb-3 d-inline-block">{{ __('Settings') }}</h2>

<div class="card border-0 shadow-sm">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('Cron job') }}</div></div>
        </div>
    </div>
    <div class="card-body">
        @include('shared.message')

        <div class="form-group">
            <label for="i_cronjob_check">{!! __(':name command', ['name' => '<span class="badge badge-primary">check</span>']) !!}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <code class="input-group-text" id="basic-addon1">1 0 * * *</code>
                </div>
                <input type="text" dir="ltr" name="cronjob_check" id="i_cronjob_check" class="form-control" value="wget {{ route('cronjob.check', ['key' => config('settings.cronjob_key')]) }} >/dev/null 2>&1" readonly>
                <div class="input-group-append">
                    <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i_cronjob_check">{{ __('Copy') }}</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="i_cronjob_clean">{!! __(':name command', ['name' => '<span class="badge badge-danger">clean</span>']) !!}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <code class="input-group-text" id="basic-addon1">0 0 * * *</code>
                </div>
                <input type="text" dir="ltr" name="cronjob_clean" id="i_cronjob_clean" class="form-control" value="wget {{ route('cronjob.clean', ['key' => config('settings.cronjob_key')]) }} >/dev/null 2>&1" readonly>
                <div class="input-group-append">
                    <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i_cronjob_clean">{{ __('Copy') }}</div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="i_cronjob_email">{!! __(':name command', ['name' => '<span class="badge badge-success">email</span>']) !!}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <code class="input-group-text" id="basic-addon1">1 0 1 * *</code>
                </div>
                <input type="text" dir="ltr" name="cronjob_email" id="i_cronjob_email" class="form-control" value="wget {{ route('cronjob.email', ['key' => config('settings.cronjob_key')]) }} >/dev/null 2>&1" readonly>
                <div class="input-group-append">
                    <div class="btn btn-primary" data-enable="tooltip-copy" title="{{ __('Copy') }}" data-copy="{{ __('Copy') }}" data-copied="{{ __('Copied') }}" data-clipboard-target="#i_cronjob_email">{{ __('Copy') }}</div>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#regenerateModal">{{ __('Regenerate') }}</button>
    </div>
</div>

<div class="card border-0 shadow-sm mt-3">
    <div class="card-header align-items-center">
        <div class="row">
            <div class="col"><div class="font-weight-medium py-1">{{ __('History') }}</div></div>
            <div class="col-auto">
                <form method="GET" action="{{ route('admin.settings.cronjob') }}">
                    <div class="input-group input-group-sm">
                        <input class="form-control" name="search" placeholder="{{ __('Search') }}" value="{{ app('request')->input('search') }}">
                        <div class="input-group-append">
                            <button type="button" class="btn {{ request()->input('sort') ? 'btn-primary' : 'btn-outline-primary' }} d-flex align-items-center dropdown-toggle dropdown-toggle-split reset-after" data-enable="tooltip" title="{{ __('Filters') }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@include('icons.filter', ['class' => 'fill-current width-4 height-4'])&#8203;</button>
                            <div class="dropdown-menu {{ (__('lang_dir') == 'rtl' ? 'dropdown-menu' : 'dropdown-menu-right') }} border-0 shadow width-64" id="search-filters">
                                <div class="dropdown-header py-1">
                                    <div class="row">
                                        <div class="col"><div class="font-weight-medium m-0 text-dark">{{ __('Filters') }}</div></div>
                                        <div class="col-auto">
                                            @if(request()->input('sort'))
                                                <a href="{{ route('admin.settings.cronjob') }}" class="text-secondary">{{ __('Reset') }}</a>
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
        @if(count($cronjobs) == 0)
            {{ __('No results found.') }}
        @else
            <div class="list-group list-group-flush my-n3">
                <div class="list-group-item px-0 text-muted">
                    <div class="row align-items-center">
                        <div class="col-12 col-sm">{{ __('Name') }}</div>
                        <div class="col-12 col-sm-auto">{{ __('Date') }}</div>
                    </div>
                </div>

                @foreach($cronjobs as $cronjob)
                    <div class="list-group-item px-0">
                        <div class="row align-items-center">
                            <div class="col-12 col-sm d-flex text-truncate">
                                @if($cronjob->name == 'check')
                                    <div class="badge badge-primary text-truncate">
                                        {{ $cronjob->name }}
                                    </div>
                                @elseif($cronjob->name == 'email')
                                    <div class="badge badge-success text-truncate">
                                        {{ $cronjob->name }}
                                    </div>
                                @elseif($cronjob->name == 'clean')
                                    <div class="badge badge-danger text-truncate">
                                        {{ $cronjob->name }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 col-sm-auto text-truncate">
                                {{ $cronjob->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format(__('Y-m-d')) }} {{ $cronjob->created_at->tz(Auth::user()->timezone ?? config('app.timezone'))->format('H:i:s') }}
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="mt-3 align-items-center">
                    <div class="row">
                        <div class="col">
                            <div class="mt-2 mb-3">{{ __('Showing :from-:to of :total', ['from' => $cronjobs->firstItem(), 'to' => $cronjobs->lastItem(), 'total' => $cronjobs->total()]) }}
                            </div>
                        </div>
                        <div class="col-auto">
                            {{ $cronjobs->onEachSide(1)->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<div class="modal fade" id="regenerateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-0 shadow">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">{{ __('Regenerate') }}</h6>
                <button type="button" class="close d-flex align-items-center justify-content-center width-12 height-14" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="d-flex align-items-center">@include('icons.close', ['class' => 'fill-current width-3 height-3'])</span>
                </button>
            </div>
            <div class="modal-body">
                <div>{{ __('If you regenerate the cron job key, you will need to update the cron job tasks with the new commands.') }}</div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                <form action="{{ route('admin.settings.cronjob') }}" method="post" enctype="multipart/form-data">

                    @csrf

                    <button type="submit" class="btn btn-danger">{{ __('Regenerate') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    'use strict';

    window.addEventListener('DOMContentLoaded', function () {
        new ClipboardJS('.btn');
    });
</script>