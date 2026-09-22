@include('backend.template.header')

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'super-admin')
    @include('backend.template.sidebar')
@endif

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'tenaga-kerja')
    @include('backend.template.sidebar-pencari')
@endif

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'penyedia-kerja')
    @include('backend.template.sidebar-penyedia')
@endif

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'admin-bkk')
    @include('backend.template.sidebar-bkk')
@endif

@if (Auth::check() && Auth::user()->roles[0]['name'] == 'admin-blk')
    @include('backend.template.sidebar-blk')
@endif


<body>
    @yield('content')

    @include('components.wa-sipet-widget')
    @include('backend.template.footer')
    @stack('js')
</body>

</html>
