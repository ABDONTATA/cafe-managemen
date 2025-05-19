<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Café Management</title>
    
    <!-- Aprycot Template CSS -->
    <link rel="stylesheet" href="{{ asset('aprycot/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('aprycot/css/style.css') }}">
    <!-- Add other CSS files from Aprycot template -->
    
    @yield('styles')
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-header">
                <h3>Café Management</h3>
            </div>

            <ul class="list-unstyled components">
                <li class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories.index') }}">
                        <i class="fas fa-tags"></i>
                        Categories
                    </a>
                </li>
                <li>
                    <a href="{{ route('produits.index') }}">
                        <i class="fas fa-coffee"></i>
                        Products
                    </a>
                </li>
                <li>
                    <a href="{{ route('commandes.index') }}">
                        <i class="fas fa-receipt"></i>
                        Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('tables.index') }}">
                        <i class="fas fa-chair"></i>
                        Tables
                    </a>
                </li>
                <li>
                    <a href="{{ route('user-add') }}">
                        <i class="fas fa-users"></i>
                        Users
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content -->
        <div id="content">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="btn btn-info">
                        <i class="fas fa-align-left"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('aprycot/js/jquery.min.js') }}"></script>
    <script src="{{ asset('aprycot/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('aprycot/js/chart.js') }}"></script>
    <!-- Add other JS files from Aprycot template -->

    @yield('scripts')

    <script>
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
</body>
</html> 