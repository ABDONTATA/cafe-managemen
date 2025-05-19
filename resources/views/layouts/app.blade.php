<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'Café Management') }}</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}" />
    
    <!-- Library / Plugin Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/core/libs.min.css') }}" />
    
    <!-- Aprycot Design System CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/aprycot.min.css') }}" />
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css') }}" />

    @stack('styles')
</head>
<body class="@yield('body-class', '')">
    <div id="loading">
        @include('layouts.partials.loader')
    </div>
    
    <aside class="sidebar sidebar-default sidebar-white sidebar-base navs-rounded-all">
        @include('layouts.partials.sidebar')
    </aside>
    
    <main class="main-content">
        <div class="position-relative">
            @include('layouts.partials.header')
        </div>
        <div class="content-inner container-fluid pb-0">
            @include('layouts.partials.flash-messages')
            
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <div class="header-title">
                                <h4 class="card-title">@yield('page-title')</h4>
                                <p class="text-muted mb-0">@yield('page-subtitle')</p>
                            </div>
                            <div class="d-flex align-items-center">
                                @yield('page-actions')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @yield('content')
        </div>
        
        @include('layouts.partials.footer')
    </main>
    
    <!-- Library Bundle Script -->
    <script src="{{ asset('assets/js/core/libs.min.js') }}"></script>
    
    <!-- External Library Bundle Script -->
    <script src="{{ asset('assets/js/core/external.min.js') }}"></script>
    
    <!-- App Script -->
    <script src="{{ asset('assets/js/aprycot.js') }}"></script>

    @stack('scripts')
    @yield('scripts')
</body>
</html>
