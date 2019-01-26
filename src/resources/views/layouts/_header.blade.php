<header class="blog-header py-3">
    <div class="row align-items-center">
        <div class="col-12 col-md-8">
            <h1>
                <a href="/">
                    <img src="{{ asset('img/logo.png') }}" height="50" alt="Logo" />    {{ config('app.name') }}
                </a>
            </h1>
        </div>
        <div class="col-12 col-md-4 align-items-end text-right">
            @yield('topright')
        </div>
    </div>
</header>
