<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MCG Projects') }}</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    <div id="app" class="d-flex flex-column flex-grow-1">
        <nav class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm sticky-top">
            <div class="container">
                <a class="navbar-brand d-flex align-items-center fw-bold text-white letter-spacing-tight" href="{{ url('/') }}">
                    <img src="{{ asset('images/logos/mcg-logo.png') }}" alt="MCG" height="36" class="me-2 bg-white rounded-circle p-1">
                    MCG Projects
                </a>
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto align-items-center">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link text-white-50 hover-white px-3" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link btn btn-outline-light btn-sm px-4 ms-2 rounded-pill" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white-50 hover-white px-3" href="{{ route('home') }}">Map</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white fw-medium ps-3" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-3 overflow-hidden" aria-labelledby="navbarDropdown">
                                    <div class="px-3 py-2 bg-light border-bottom">
                                        <small class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem;">Account</small>
                                    </div>
                                    
                                    <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard
                                    </a>
                                    <a class="dropdown-item py-2" href="{{ route('admin.projects.index') }}">
                                        <i class="bi bi-folder me-2 text-primary"></i> Projects
                                    </a>
                                    <a class="dropdown-item py-2" href="{{ route('admin.tracking.index') }}">
                                        <i class="bi bi-activity me-2 text-primary"></i> Tracking
                                    </a>
                                    <a class="dropdown-item py-2" href="{{ route('admin.activity.index') }}">
                                        <i class="bi bi-clock-history me-2 text-primary"></i> Activity Log
                                    </a>
                                    
                                    @if(Auth::user()->isSuperAdmin())
                                        <div class="dropdown-divider my-0"></div>
                                        <a class="dropdown-item py-2" href="{{ route('admin.users.index') }}">
                                            <i class="bi bi-people me-2 text-primary"></i> Users
                                        </a>
                                    @endif
                                    
                                    <div class="dropdown-divider my-0"></div>
                                    
                                    <a class="dropdown-item py-2" href="{{ route('password.change') }}">
                                        <i class="bi bi-key me-2 text-secondary"></i> Change Password
                                    </a>

                                    <div class="dropdown-divider my-0"></div>

                                    <a class="dropdown-item py-2 text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                        <li class="nav-item ms-2">
                            <button id="theme-toggle" class="btn btn-link text-white-50 hover-white p-0 border-0 fs-5" title="Toggle Theme">
                                <i class="bi bi-moon-stars"></i>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-5">
            @yield('content')
        </main>
        
        <footer class="bg-white border-top py-4 mt-auto">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start">
                        <span class="text-muted small">&copy; {{ date('Y') }} <strong>MCG Projects</strong>. All rights reserved.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item"><a href="#" class="text-muted small text-decoration-none hover-primary">Privacy</a></li>
                            <li class="list-inline-item ms-3"><a href="#" class="text-muted small text-decoration-none hover-primary">Terms</a></li>
                            <li class="list-inline-item ms-3"><a href="#" class="text-muted small text-decoration-none hover-primary">Support</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Bootstrap JS (Bundled with Vite) -->
    <script>
        // Dark Mode Logic
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;

        const savedTheme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(savedTheme);

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                applyTheme(newTheme);
                localStorage.setItem('theme', newTheme);
                // Dispatch event for components that need to know (like charts)
                window.dispatchEvent(new Event('themeChanged'));
            });
        }

        function applyTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            if (themeToggle) {
                const icon = themeToggle.querySelector('i');
                if (theme === 'dark') {
                    icon.className = 'bi bi-sun-fill';
                } else {
                    icon.className = 'bi bi-moon-stars';
                }
            }
        }

        // AJAX Pagination Logic
        document.addEventListener('DOMContentLoaded', function() {
            document.addEventListener('click', function(e) {
                // Check if the clicked element is a pagination link inside one of our containers
                const link = e.target.closest('.pagination a');
                if (!link) return;

                const container = link.closest('#dashboard-projects-container, #projects-index-container, #tracking-index-container, #activity-index-container');
                
                if (container) {
                    e.preventDefault();
                    
                    const url = link.getAttribute('href');
                    
                    // Add opacity to indicate loading
                    container.style.opacity = '0.5';
                    container.style.transition = 'opacity 0.2s';

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.text())
                    .then(html => {
                        container.innerHTML = html;
                        container.style.opacity = '1';
                        
                        // Update URL without refresh (optional, but good for bookmarking if implemented fully)
                        // history.pushState(null, '', url); 
                    })
                    .catch(error => {
                        console.error('Error loading pagination:', error);
                        container.style.opacity = '1';
                        // Fallback to normal navigation
                        window.location.href = url;
                    });
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                showToast('success', "{{ session('success') }}");
            @endif

            @if(session('error'))
                showToast('error', "{{ session('error') }}");
            @endif
        });
    </script>
    @stack('scripts')
</body>

</html>