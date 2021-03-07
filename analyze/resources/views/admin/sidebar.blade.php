@section('menu')
    @php
        /**
         * key => [icon, title, route, [
         *  subKey => [title, route]
         * ]]
         */
        $menu = [
            'dashboard' => ['dashboard', 'Dashboard', 'admin.dashboard'],
            'settings' => ['settings', 'Settings', null, [
                'general' => ['General', 'admin.settings.general'],
                'appearance' => ['Appearance', 'admin.settings.appearance'],
                'email' => ['Email', 'admin.settings.email'],
                'social' => ['Social', 'admin.settings.social'],
                'payment' => ['Payment', 'admin.settings.payment'],
                'registration' => ['Registration', 'admin.settings.registration'],
                'legal' => ['Legal', 'admin.settings.legal'],
                'invoice' => ['Invoice', 'admin.settings.invoice'],
                'contact' => ['Contact', 'admin.settings.contact'],
                'captcha' => ['Captcha', 'admin.settings.captcha'],
                'cronjob' => ['Cron job', 'admin.settings.cronjob'],
                'analytics' => ['Analytics', 'admin.settings.analytics']
            ]],
            'languages' => ['language', 'Languages', 'admin.languages'],
            'plans' => ['package', 'Plans', 'admin.plans'],
            'subscriptions' => ['subscription', 'Subscriptions', 'admin.subscriptions'],
            'users' => ['users', 'Users', 'admin.users'],
            'websites' => ['website', 'Websites', 'admin.websites'],
            'pages' => ['pages', 'Pages', 'admin.pages'],
        ];
    @endphp

    <div class="nav d-block text-truncate">
        @foreach ($menu as $key => $value)
            <li class="nav-item">
                <a class="nav-link d-flex px-4 @if (request()->segment(2) == $key && isset($value[3]) == false) active @endif" @if(isset($value[3])) data-toggle="collapse" href="#subMenu-{{ $key }}" role="button" @if (array_key_exists(request()->segment(3), $value[3])) aria-expanded="true" @else aria-expanded="false" @endif aria-controls="collapse-{{ $key }}" @else href="{{ (Route::has($value[2]) ? route($value[2]) : $value[2]) }}" @endif>
                    <span class="sidebar-icon d-flex align-items-center">@include('icons.' . $value[0], ['class' => 'fill-current width-4 height-4 '.(__('lang_dir') == 'rtl' ? 'ml-3' : 'mr-3')])</span>
                    <span class="flex-grow-1 text-truncate">{{ __($value[1]) }}</span>
                    @if (isset($value[3])) <span class="d-flex align-items-center ml-auto sidebar-expand">@include('icons.expand', ['class' => 'fill-current text-muted width-3 height-3'])</span> @endif
                </a>
            </li>

            @if (isset($value[3]))
                <div class="collapse sub-menu @if (request()->segment(2) == $key) show @endif" id="subMenu-{{ $key }}">
                    @foreach ($value[3] as $subKey => $subValue)
                        <a href="{{ (Route::has($subValue[1]) ? route($subValue[1]) : $subValue[1]) }}" class="nav-link text-truncate @if (request()->segment(3) == $subKey) active @endif">{{ __($subValue[0]) }}</a>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>
@endsection