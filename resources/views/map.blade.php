<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MCG Projects') }} - Map of Nigeria Projects</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #334155;
        }

        .navbar-landing {
            background-color: #fff;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            padding: 1rem 0;
        }

        .logo-img {
            height: 40px;
            width: auto;
        }

        .map-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            height: 100%;
        }

        .sidebar-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid #e2e8f0;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .sidebar-header {
            padding: 1.25rem;
            border-bottom: 1px solid #f1f5f9;
            background: #fff;
        }

        .project-list-container {
            flex: 1;
            overflow-y: auto;
            min-height: 0; /* Important for flex scrolling */
            padding: 1rem;
        }

        .project-item {
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.2s ease;
            border-left: 4px solid #0f172a; /* Primary */
            position: relative;
        }

        .project-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-color: #cbd5e1;
        }

        .project-item h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        
        .status-ongoing { background-color: #fffbeb; color: #b45309; border: 1px solid #fcd34d; }
        .status-completed { background-color: #ecfdf5; color: #047857; border: 1px solid #6ee7b7; }
        .status-pending { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fca5a5; }
        .status-planned { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #93c5fd; }
        .status-operation { background-color: #f0fdf4; color: #15803d; border: 1px solid #86efac; }
        .status-suspended { background-color: #fff1f2; color: #be123c; border: 1px solid #fda4af; }

        /* Map Styling */
        #nigeria-map {
            width: 100%;
            height: auto;
            max-height: 700px;
        }

        #nigeria-map path {
            fill: #f1f5f9;
            stroke: #cbd5e1;
            stroke-width: 1;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #nigeria-map path:hover {
            fill: #e2e8f0;
            stroke: #94a3b8;
        }

        /* Active State Color - Lighter as requested */
        #nigeria-map path.active {
            fill: #bae6fd; /* Sky 200 */
            stroke: #0284c7; /* Sky 600 */
            stroke-width: 2;
        }
        
        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: #fff;
            border-radius: 0.5rem;
            padding: 0.75rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border-color: #3b82f6;
            cursor: pointer;
        }

        .stat-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .stat-info h3 {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
            line-height: 1;
        }

        .stat-info p {
            color: #64748b;
            font-size: 0.65rem;
            font-weight: 600;
            margin: 0.1rem 0 0 0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Tooltip */
        .state-tooltip {
            position: fixed;
            background: #0f172a;
            color: #fff;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 500;
            pointer-events: none;
            z-index: 1050;
            display: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        /* Modal Redesign */
        .modal-content {
            border: none;
            border-radius: 1.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .modal-header {
            border-bottom: 1px solid #f1f5f9;
            padding: 1.5rem;
            background: #fff;
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
        }

        .modal-title {
            font-weight: 700;
            color: #0f172a;
            font-size: 1.25rem;
        }

        .modal-body {
            padding: 0;
        }

        /* Slideshow Styling */
        .slideshow-container {
            background: #000;
            position: relative;
            height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        
        .slide img {
            height: 100%;
            width: 100%;
            object-fit: contain;
        }

        .slide-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            backdrop-filter: blur(4px);
        }

        .slide-nav-btn:hover {
            background: rgba(255, 255, 255, 0.4);
        }

        .prev-btn { left: 1rem; }
        .next-btn { right: 1rem; }

        .project-details-content {
            padding: 2rem;
            background: #fff;
            border-bottom-left-radius: 1.5rem;
            border-bottom-right-radius: 1.5rem;
        }

        .detail-row {
            display: flex;
            margin-bottom: 1rem;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 1rem;
        }

        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .detail-label {
            width: 120px;
            font-size: 0.875rem;
            color: #64748b;
            font-weight: 600;
            flex-shrink: 0;
        }

        .detail-value {
            color: #334155;
            font-size: 0.95rem;
            font-weight: 500;
            line-height: 1.6;
        }

        .slide-dots {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
            z-index: 10;
        }
        
        .dot {
            width: 8px;
            height: 8px;
            background: rgba(255,255,255,0.4);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .dot.active {
            background: #fff;
            transform: scale(1.2);
        }
        
        .image-caption {
            position: absolute;
            bottom: 30px; /* Above dots */
            left: 0;
            width: 100%;
            text-align: center;
            color: #fff;
            background: rgba(0, 0, 0, 0.6);
            padding: 8px;
            font-size: 0.85rem;
            backdrop-filter: blur(2px);
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes slideInLeft {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        .slide-in-right { animation: slideInRight 0.3s ease-out; }
        .slide-in-left { animation: slideInLeft 0.3s ease-out; }
        .slide-fade { animation: fadeScale 0.4s ease-out; }

        /* Footer */
        footer {
            background: #fff;
            border-top: 1px solid #e2e8f0;
            padding: 2rem 0;
            margin-top: auto;
        }

        /* Filter Styles */
        .filter-container {
            padding: 0.75rem 1.25rem;
            background: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            gap: 0.5rem;
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .filter-container::-webkit-scrollbar {
            display: none;
        }
        .filter-btn {
            white-space: nowrap;
            padding: 0.35rem 0.85rem;
            border-radius: 2rem;
            font-size: 0.75rem;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
        }
        .filter-btn:hover {
            border-color: #cbd5e1;
            background: #f1f5f9;
        }
        .filter-btn.active {
            background: #0f172a;
            color: #fff;
            border-color: #0f172a;
        }

        /* Search Bar Styles */
        .search-container {
            padding: 0.75rem 1.25rem;
            background: #fff;
            border-bottom: 1px solid #f1f5f9;
        }
        .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }
        .search-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.95rem;
            pointer-events: none;
            line-height: 1;
        }
        .search-input {
            width: 100%;
            padding: 0.5rem 1rem 0.5rem 2.5rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .search-input:focus {
            outline: none;
            border-color: #3b82f6;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .search-clear {
            position: absolute;
            right: 0.6rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            display: none;
            padding: 0.25rem;
            border-radius: 50%;
            transition: all 0.2s;
            line-height: 1;
            z-index: 5;
        }
        .search-clear:hover {
            background: #f1f5f9;
            color: #64748b;
        }

        /* Dark Mode Overrides */
        [data-bs-theme="dark"] body {
            background-color: #0f172a;
            color: #f1f5f9;
        }
        [data-bs-theme="dark"] .navbar-landing {
            background-color: #1e293b;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }
        [data-bs-theme="dark"] .text-dark {
            color: #f1f5f9 !important;
        }
        [data-bs-theme="dark"] .text-muted {
            color: #94a3b8 !important;
        }
        [data-bs-theme="dark"] .map-card,
        [data-bs-theme="dark"] .sidebar-card,
        [data-bs-theme="dark"] .stat-card,
        [data-bs-theme="dark"] .project-item,
        [data-bs-theme="dark"] .modal-content,
        [data-bs-theme="dark"] .modal-header,
        [data-bs-theme="dark"] .project-details-content,
        [data-bs-theme="dark"] footer,
        [data-bs-theme="dark"] .filter-btn {
            background-color: #1e293b;
            border-color: #334155;
            color: #f1f5f9;
        }
        [data-bs-theme="dark"] .sidebar-header,
        [data-bs-theme="dark"] .detail-row,
        [data-bs-theme="dark"] .filter-container,
        [data-bs-theme="dark"] .search-container {
            background-color: #1e293b;
            border-color: #334155;
        }
        [data-bs-theme="dark"] .search-input {
            background-color: #0f172a;
            border-color: #334155;
            color: #f1f5f9;
        }
        [data-bs-theme="dark"] .search-input:focus {
            border-color: #38bdf8;
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.1);
        }
        [data-bs-theme="dark"] .project-item h4,
        [data-bs-theme="dark"] .modal-title,
        [data-bs-theme="dark"] .detail-value,
        [data-bs-theme="dark"] .stat-info h3 {
            color: #f1f5f9;
        }
        [data-bs-theme="dark"] .project-item:hover,
        [data-bs-theme="dark"] .stat-card:hover {
            border-color: #475569;
            background-color: #334155;
        }
        [data-bs-theme="dark"] #map-wrapper {
            background-color: #0f172a !important;
        }
        [data-bs-theme="dark"] #nigeria-map path {
            fill: #1e293b;
            stroke: #334155;
        }
        [data-bs-theme="dark"] #nigeria-map path:hover {
            fill: #334155;
            stroke: #64748b;
        }
        [data-bs-theme="dark"] #nigeria-map path.active {
            fill: #0c4a6e; /* Darker Sky 900 */
            stroke: #38bdf8; /* Sky 400 */
        }
        [data-bs-theme="dark"] .badge.bg-light {
            background-color: #334155 !important;
            color: #e2e8f0 !important;
            border-color: #475569 !important;
        }
        [data-bs-theme="dark"] .filter-btn:hover {
            background-color: #334155;
            border-color: #475569;
        }
        [data-bs-theme="dark"] .filter-btn.active {
            background-color: #38bdf8;
            border-color: #38bdf8;
            color: #0f172a;
        }
        [data-bs-theme="dark"] .detail-label {
            color: #94a3b8;
        }
        [data-bs-theme="dark"] .btn-outline-primary {
            color: #38bdf8;
            border-color: #38bdf8;
        }
        [data-bs-theme="dark"] .btn-outline-primary:hover {
            background-color: #38bdf8;
            color: #0f172a;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar-landing sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand d-flex align-items-center gap-3" href="{{ url('/') }}">
                <img src="{{ asset('images/logos/mcg-logo.png') }}" alt="MCG" class="bg-white rounded-circle p-1 shadow-sm logo-img">
                <div class="d-flex flex-column">
                    <span class="fw-bold text-dark lh-1">MCG Projects</span>
                    <span class="small text-muted" style="font-size: 0.75rem; letter-spacing: 0.05em;">NIGERIA PROJECTS MAP</span>
                </div>
            </a>
            <div class="d-flex align-items-center gap-3">
                <button id="theme-toggle" class="btn btn-link p-0 border-0 fs-5 text-muted" title="Toggle Theme">
                    <i class="bi bi-moon-stars"></i>
                </button>
                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">
                        <i class="bi bi-lock-fill me-2"></i>Admin Login
                    </a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary px-4 rounded-pill fw-bold">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Map Section -->
                <div class="col-lg-8">
                    <div class="map-card p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold text-dark mb-0">Project Locations</h4>
                            <span class="badge bg-light text-muted border">Interactive Map</span>
                        </div>
                        <div id="map-wrapper" class="bg-light rounded-3 p-3 position-relative" style="min-height: 500px; overflow: hidden;">
                            <div class="skeleton-map h-100 w-100 position-absolute top-0 start-0 p-4">
                                <div class="skeleton mb-2" style="height: 100%; border-radius: 1rem;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Section -->
                <div class="col-lg-4">
                    <div class="sidebar-card">
                        <div class="sidebar-header d-flex justify-content-between align-items-center">
                            <h5 class="fw-bold text-dark mb-0">Projects List</h5>
                            <span id="state-badge" class="badge bg-primary rounded-pill">Select a State</span>
                        </div>
                        <div class="search-container" id="search-section" style="display: none;">
                            <div class="search-wrapper">
                                <i class="bi bi-search search-icon"></i>
                                <input type="text" id="project-search" class="search-input" placeholder="Search projects..." autocomplete="off">
                                <button id="clear-search" class="search-clear">
                                    <i class="bi bi-x-circle-fill"></i>
                                </button>
                            </div>
                        </div>
                        <div id="status-filters" class="filter-container" style="display: none;">
                            <button class="filter-btn active" onclick="filterByStatus('all')">All</button>
                            <button class="filter-btn" onclick="filterByStatus('ongoing')">Ongoing</button>
                            <button class="filter-btn" onclick="filterByStatus('completed')">Completed</button>
                            <button class="filter-btn" onclick="filterByStatus('operation')">Operational</button>
                            <button class="filter-btn" onclick="filterByStatus('suspended')">Suspended</button>
                        </div>
                        <div class="project-list-container custom-scrollbar" id="project-list">
                            <div class="text-center py-5 px-3">
                                <i class="bi bi-pin-map text-muted opacity-25" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-3 mb-0">Select any highlighted state on the map to view detailed projects in that region.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Section -->
            <div class="stats-container">
                <div class="stat-card" onclick="loadGlobalProjects('all')">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-folder2-open"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="total-projects">0</h3>
                        <p>Total Projects</p>
                    </div>
                </div>
                <div class="stat-card" onclick="loadGlobalProjects('ongoing')">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="ongoing-projects">0</h3>
                        <p>Ongoing</p>
                    </div>
                </div>
                <div class="stat-card" onclick="loadGlobalProjects('completed')">
                    <div class="stat-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="completed-projects">0</h3>
                        <p>Completed</p>
                    </div>
                </div>
                <div class="stat-card" onclick="loadGlobalProjects('suspended')">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                        <i class="bi bi-pause-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="suspended-projects">0</h3>
                        <p>Suspended</p>
                    </div>
                </div>
                <div class="stat-card" onclick="loadGlobalProjects('operation')">
                    <div class="stat-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-gear-wide-connected"></i>
                    </div>
                    <div class="stat-info">
                        <h3 id="operational-projects">0</h3>
                        <p>Operational</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="text-muted small mb-0">&copy; {{ date('Y') }} Mutual Commitment Group. All rights reserved.</p>
        </div>
    </footer>

    <!-- Tooltip -->
    <div id="tooltip" class="state-tooltip"></div>

    <!-- Project Details Modal -->
    <div class="modal fade" id="projectModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-project-name">Project Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Slideshow -->
                    <div id="slideshow-container" class="slideshow-container">
                        <div id="slides-wrapper" style="width: 100%;">
                            <!-- Slides injected here -->
                        </div>
                        <button class="slide-nav-btn prev-btn" onclick="changeSlide(-1)">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <button class="slide-nav-btn next-btn" onclick="changeSlide(1)">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                        <div id="slide-dots" class="slide-dots"></div>
                    </div>
                    
                    <!-- Details -->
                    <div class="project-details-content">
                        <div class="detail-row">
                            <div class="detail-label"><i class="bi bi-geo-alt me-2"></i>Location</div>
                            <div class="detail-value" id="modal-state"></div>
                        </div>
                        <div class="detail-row" id="modal-awarded-row" style="display: none;">
                            <div class="detail-label"><i class="bi bi-calendar-check me-2"></i>Awarded</div>
                            <div class="detail-value" id="modal-awarded"></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label"><i class="bi bi-flag me-2"></i>Status</div>
                            <div class="detail-value" id="modal-status"></div>
                        </div>
                        <div class="detail-row" id="modal-description-row">
                            <div class="detail-label"><i class="bi bi-card-text me-2"></i>Description</div>
                            <div class="detail-value" id="modal-description"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logic Script -->
    <script>
        let myModal;
        let currentStateProjects = [];
        let currentStatusFilter = 'all';
        let currentSearchQuery = '';
        let currentStateName = '';

        // Dark Mode Logic (Layout independent)
        const themeToggle = document.getElementById('theme-toggle');
        const htmlElement = document.documentElement;
        
        // Initial Theme Load
        const savedTheme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        applyTheme(savedTheme);

        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                applyTheme(newTheme);
                localStorage.setItem('theme', newTheme);
            });
        }

        function applyTheme(theme) {
            htmlElement.setAttribute('data-bs-theme', theme);
            if (themeToggle) {
                const icon = themeToggle.querySelector('i');
                if (theme === 'dark') {
                    icon.className = 'bi bi-sun-fill text-warning'; // Sun for dark mode
                } else {
                    icon.className = 'bi bi-moon-stars text-muted'; // Moon for light mode
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            console.log('Map page loaded');
            // Load content first
            loadStatistics();
            loadMap();

            // Search Logic
            const searchInput = document.getElementById('project-search');
            const clearBtn = document.getElementById('clear-search');

            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    currentSearchQuery = e.target.value.toLowerCase();
                    clearBtn.style.display = currentSearchQuery.length > 0 ? 'block' : 'none';
                    renderProjects(currentStatusFilter);
                });
            }

            if (clearBtn) {
                clearBtn.addEventListener('click', () => {
                    searchInput.value = '';
                    currentSearchQuery = '';
                    clearBtn.style.display = 'none';
                    searchInput.focus();
                    renderProjects(currentStatusFilter);
                });
            }

            // Then try to init modal
            try {
                if (typeof bootstrap !== 'undefined') {
                    myModal = new bootstrap.Modal(document.getElementById('projectModal'));
                } else {
                    console.warn('Bootstrap not loaded yet. Modal may not work immediately.');
                    // Fallback or retry?
                    // For now, let's just log it. app.js should load it.
                }
            } catch (e) {
                console.error('Error initializing modal:', e);
            }
        });

        function loadStatistics() {
            fetch('/api/projects/statistics')
                .then(r => r.json())
                .then(stats => {
                    document.getElementById('total-projects').textContent = stats.total || 0;
                    document.getElementById('ongoing-projects').textContent = stats.ongoing || 0;
                    document.getElementById('completed-projects').textContent = stats.completed || 0;
                    document.getElementById('suspended-projects').textContent = stats.suspended || 0;
                    document.getElementById('operational-projects').textContent = stats.operational || 0;
                })
                .catch(console.error);
        }

        function loadMap() {
            Promise.all([
                fetch('/svg/nigeria-mapp.svg').then(res => {
                    if (!res.ok) throw new Error('Failed to load SVG');
                    return res.text();
                }),
                fetch('/api/projects/states-with-projects').then(res => {
                    if (!res.ok) throw new Error('Failed to load States API');
                    return res.json();
                })
            ])
            .then(([svgData, activeStates]) => {
                const wrapper = document.getElementById('map-wrapper');
                
                // Strip hardcoded width/height to make SVG responsive via viewBox
                svgData = svgData.replace(/width\s*=\s*"[^"]*"/gi, '')
                                 .replace(/height\s*=\s*"[^"]*"/gi, '');
                
                wrapper.innerHTML = svgData;
                const svg = wrapper.querySelector('svg');
                if (svg) {
                    svg.id = 'nigeria-map';
                    svg.style.width = '100%';
                    svg.style.height = 'auto'; // Let it maintain aspect ratio
                    svg.style.maxHeight = '700px';
                }
                
                initializeMap(activeStates);
                
                // Sync height after map render
                setTimeout(syncSidebarHeight, 100);
            })
            .catch(error => {
                console.error('Error loading map:', error);
                document.getElementById('map-wrapper').innerHTML = 
                    '<div class="text-danger p-4 text-center">Failed to load map data. Please refresh.</div>';
            });
        }
        
        function syncSidebarHeight() {
            const mapCard = document.querySelector('.map-card');
            const sidebarCard = document.querySelector('.sidebar-card');
            
            // Only on desktop (lg breakpoint is usually 992px)
            if (window.innerWidth >= 992 && mapCard && sidebarCard) {
                // Get the computed height of the map card
                const height = mapCard.offsetHeight;
                
                // Set the sidebar to be exactly that height
                sidebarCard.style.height = height + 'px';
                sidebarCard.style.maxHeight = height + 'px';
            } else if (sidebarCard) {
                // Reset on mobile
                sidebarCard.style.height = '';
                sidebarCard.style.maxHeight = '';
            }
        }
        
        // Listen for resize
        window.addEventListener('resize', syncSidebarHeight);

        function initializeMap(activeStates) {
            console.log('Initializing map with active states:', activeStates);
            const svg = document.querySelector('#nigeria-map');
            
            if (!svg) {
                console.error('SVG element #nigeria-map not found in DOM');
                return;
            }

            // Force visibility
            svg.style.display = 'block';
            svg.style.width = '100%';
            svg.style.height = '100%';

            const paths = svg.querySelectorAll('path');
            const tooltip = document.getElementById('tooltip');

            // Normalize active states if activeStates is valid
            const normalizedActiveStates = Array.isArray(activeStates) 
                ? activeStates.map(s => String(s).toLowerCase()) 
                : [];
            
            // Light/Pastel Colors Palette
            const colors = [
                '#dcfce7', '#fef9c3', '#fee2e2', '#dbeafe', '#f3e8ff', 
                '#ffedd5', '#e0f2fe', '#fce7f3', '#ecfccb', '#f3f4f6'
            ];

            paths.forEach((path, index) => {
                const stateName = path.getAttribute('title') || path.getAttribute('id');

                if (!stateName) return; // Skip paths without identifiers
                
                // Assign random stable color based on name char code sum
                const charCodeSum = stateName.split('').reduce((a, b) => a + b.charCodeAt(0), 0);
                const colorIndex = charCodeSum % colors.length;
                const baseColor = colors[colorIndex];

                // Normalize state name for comparison (FCT fix)
                let comparisonName = stateName;
                if (stateName === 'Federal Capital Territory') {
                    comparisonName = 'FCT';
                } else if (stateName === 'FCT') {
                    // Just in case SVG changes
                    comparisonName = 'FCT';
                }

                // Initial styling
                path.style.fill = baseColor;
                path.style.stroke = '#94a3b8';
                path.style.strokeWidth = '1';
                path.style.cursor = 'pointer';
                path.style.transition = 'all 0.3s ease';
                path.style.vectorEffect = 'non-scaling-stroke'; // Keep stroke consistent
                
                // Add labels centered on the state
                try {
                    // Only add if not already added (in case of re-init)
                    // ... (label logic remains or can be refined)
                    
                    const bbox = path.getBBox();
                    const centerX = bbox.x + bbox.width / 2;
                    const centerY = bbox.y + bbox.height / 2;

                    // Check if label already exists
                    // We can skip uniqueness check if we assume clean slate, but let's be safe
                    // Simplified for this context:
                    
                     const text = document.createElementNS("http://www.w3.org/2000/svg", "text");
                    text.setAttribute("x", centerX);
                    text.setAttribute("y", centerY);
                    text.setAttribute("text-anchor", "middle");
                    text.setAttribute("dominant-baseline", "middle");
                    text.setAttribute("fill", "#334155");
                    text.setAttribute("font-size", "10px");
                    text.setAttribute("font-weight", "600");
                    text.setAttribute("pointer-events", "none"); 
                    text.textContent = stateName;
                    
                    // Only append if valid coords
                    if (!isNaN(centerX) && !isNaN(centerY)) {
                        
                        
                        // If state has projects, verify and add logo
                        if (normalizedActiveStates.includes(comparisonName.toLowerCase())) {
                            const logoSize = 15;
                            const logo = document.createElementNS("http://www.w3.org/2000/svg", "image");
                            logo.setAttributeNS("http://www.w3.org/1999/xlink", "href", "/images/logos/mcg-logo.png");
                            logo.setAttribute("href", "/images/logos/mcg-logo.png"); // Standard
                            logo.setAttribute("x", centerX - (logoSize / 2));
                            logo.setAttribute("y", centerY - (logoSize / 2) - 8); // Move up slightly
                            logo.setAttribute("width", logoSize);
                            logo.setAttribute("height", logoSize);
                            logo.setAttribute("pointer-events", "none");
                            svg.appendChild(logo);

                            // Shift text down slightly
                            text.setAttribute("y", centerY + 8);
                        }

                        svg.appendChild(text);
                    }
                } catch (e) {
                    console.warn("Could not calculate BBox for " + stateName);
                }


                // Add active class if it has projects (optional, for other styling/logic)
                if (stateName && normalizedActiveStates.includes(comparisonName.toLowerCase())) {
                    path.classList.add('has-projects');
                    // path.style.stroke = '#0284c7'; // Optional: Highlight border for active states
                    // path.style.strokeWidth = '2';
                }

                // Click Event for ALL states
                path.addEventListener('click', () => {
                    // Use the comparison name (FCT) for API calls if needed, 
                    // or user might prefer the display name. 
                    // The API likely expects 'FCT' if that's what is in DB.
                    loadProjectsByState(comparisonName);
                    
                    // Visual feedback
                    paths.forEach((p, i) => {
                         // Reset to original color
                         const sum = (p.getAttribute('title') || p.getAttribute('id')).split('').reduce((a, b) => a + b.charCodeAt(0), 0);
                         p.style.fill = colors[sum % colors.length];
                    });
                    path.style.fill = '#cbd5e1'; // Darker highlight on selection
                    
                    document.getElementById('state-badge').textContent = stateName; // Keep display name for UI
                    document.getElementById('state-badge').className = 'badge bg-primary rounded-pill';
                });

                // Tooltip logic
                path.addEventListener('mousemove', (e) => {
                    tooltip.style.display = 'block';
                    tooltip.style.left = e.pageX + 10 + 'px';
                    tooltip.style.top = e.pageY + 10 + 'px';
                    tooltip.textContent = stateName + (normalizedActiveStates.includes(comparisonName.toLowerCase()) ? '' : ' (No projects)');
                });

                path.addEventListener('mouseleave', () => {
                    tooltip.style.display = 'none';
                    // Hover effect handled by CSS, but if we want JS hover for colors:
                    // path.style.fill = baseColor; 
                });
                
                // JS Hover effect since we are using inline styles which might override CSS hover
                path.addEventListener('mouseenter', () => {
                     path.style.opacity = '0.8';
                });
                path.addEventListener('mouseleave', () => {
                     path.style.opacity = '1';
                });
            });
        }

        function loadGlobalProjects(status) {
            currentStateName = status === 'all' ? 'All' : status.charAt(0).toUpperCase() + status.slice(1);
            const listContainer = document.getElementById('project-list');
            const filters = document.getElementById('status-filters');
            const stateBadge = document.getElementById('state-badge');
            
            // Highlight active stat card (visually)
            document.querySelectorAll('.stat-card').forEach(card => card.style.borderColor = '');
            const activeCard = Array.from(document.querySelectorAll('.stat-card')).find(c => c.textContent.toLowerCase().includes(status.toLowerCase()));
            if (activeCard) activeCard.style.borderColor = '#3b82f6';

            // Reset map highlights
            const paths = document.querySelectorAll('#nigeria-map path');
            paths.forEach(p => {
                const sum = (p.getAttribute('title') || p.getAttribute('id')).split('').reduce((a, b) => a + b.charCodeAt(0), 0);
                const colors = ['#dcfce7', '#fef9c3', '#fee2e2', '#dbeafe', '#f3e8ff', '#ffedd5', '#e0f2fe', '#fce7f3', '#ecfccb', '#f3f4f6'];
                p.style.fill = colors[sum % colors.length];
            });

            stateBadge.textContent = currentStateName + ' Projects';
            stateBadge.className = 'badge bg-dark rounded-pill';

            // Show Skeleton Loader
            listContainer.innerHTML = Array(3).fill(0).map(() => `
                <div class="project-item skeleton-loader" style="pointer-events: none;">
                    <div class="skeleton mb-2" style="height: 20px; width: 70%;"></div>
                    <div class="skeleton mb-2" style="height: 12px; width: 40%;"></div>
                    <div class="border-top pt-2 mt-2 d-flex justify-content-end">
                        <div class="skeleton" style="height: 10px; width: 30%;"></div>
                    </div>
                </div>
            `).join('');
            
            filters.style.display = 'none';
            document.getElementById('search-section').style.display = 'block';

            fetch(`/api/projects?status=${status}`)
                .then(r => r.json())
                .then(projects => {
                    currentStateProjects = projects;
                    if (projects.length > 0) {
                        // For global view, we don't show the secondary status filters to avoid confusion
                        currentStatusFilter = 'all';
                        renderProjects('all'); 
                    } else {
                        listContainer.innerHTML = `
                            <div class="text-center py-5">
                                <i class="bi bi-filter text-muted mb-2" style="font-size: 2rem;"></i>
                                <h6 class="text-dark fw-bold">${currentStateName} Projects</h6>
                                <p class="text-muted small">No projects found for this category.</p>
                            </div>`;
                    }
                })
                .catch(err => {
                    console.error(err);
                    listContainer.innerHTML = '<div class="text-danger text-center small">Error loading projects.</div>';
                });
        }

        function loadProjectsByState(state) {
            currentStateName = state;
            const listContainer = document.getElementById('project-list');
            const filters = document.getElementById('status-filters');
            
            // Reset stat card highlights
            document.querySelectorAll('.stat-card').forEach(card => card.style.borderColor = '');

            // Show Skeleton Loader
            listContainer.innerHTML = Array(3).fill(0).map(() => `
                <div class="project-item skeleton-loader" style="pointer-events: none;">
                    <div class="skeleton mb-2" style="height: 20px; width: 70%;"></div>
                    <div class="skeleton mb-2" style="height: 12px; width: 40%;"></div>
                    <div class="border-top pt-2 mt-2 d-flex justify-content-end">
                        <div class="skeleton" style="height: 10px; width: 30%;"></div>
                    </div>
                </div>
            `).join('');
            
            filters.style.display = 'none';
            document.getElementById('search-section').style.display = 'block';

            fetch(`/api/projects/state/${state}`)
                .then(r => r.json())
                .then(projects => {
                    currentStateProjects = projects;
                    if (projects.length > 0) {
                        filters.style.display = 'flex';
                        currentStatusFilter = 'all';
                        // Reset filter buttons
                        document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
                        document.querySelector('.filter-btn').classList.add('active');
                        renderProjects('all');
                    } else {
                        listContainer.innerHTML = `
                            <div class="text-center py-5">
                                <i class="bi bi-geo-alt text-muted mb-2" style="font-size: 2rem;"></i>
                                <h6 class="text-dark fw-bold">${state} State</h6>
                                <p class="text-muted small">No active projects being tracked in this location.</p>
                            </div>`;
                    }
                })
                .catch(err => {
                    console.error(err);
                    listContainer.innerHTML = '<div class="text-danger text-center small">Error loading projects.</div>';
                });
        }

        window.filterByStatus = function(status) {
            currentStatusFilter = status;
            
            // Update UI
            document.querySelectorAll('.filter-btn').forEach(btn => {
                if (btn.textContent.toLowerCase() === status.toLowerCase() || (status === 'all' && btn.textContent === 'All')) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            renderProjects(status);
        };

        function renderProjects(status) {
            currentStatusFilter = status;
            const listContainer = document.getElementById('project-list');
            
            let filtered = status === 'all' 
                ? currentStateProjects 
                : currentStateProjects.filter(p => p.status.toLowerCase() === status.toLowerCase());

            // Apply search filter
            if (currentSearchQuery) {
                filtered = filtered.filter(p => 
                    (p.name && p.name.toLowerCase().includes(currentSearchQuery)) || 
                    (p.description && p.description.toLowerCase().includes(currentSearchQuery))
                );
            }

            if (filtered.length === 0) {
                if (currentSearchQuery) {
                    listContainer.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-search text-muted opacity-50 mb-2" style="font-size: 1.5rem;"></i>
                            <p class="text-muted small">No projects matching "<strong>${currentSearchQuery}</strong>" found.</p>
                        </div>`;
                } else {
                    listContainer.innerHTML = `
                        <div class="text-center py-5">
                            <i class="bi bi-filter text-muted opacity-50 mb-2" style="font-size: 1.5rem;"></i>
                            <p class="text-muted small">No projects with status <strong>${status}</strong> found in ${currentStateName}.</p>
                        </div>`;
                }
                return;
            }

            let html = `<div class="mb-3"><h6 class="fw-bold text-dark px-2 border-start border-4 border-primary">${currentStateName} Projects (${filtered.length})</h6></div>`;
            filtered.forEach(p => {
                html += `
                    <div class="project-item" onclick="openProjectModal('${p.id}')">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h4 class="mb-0 text-wrap me-2" title="${p.name}">${p.name}</h4>
                            <span class="status-badge status-${p.status} flex-shrink-0" style="font-size: 0.65rem; padding: 0.2rem 0.6rem;">${p.status}</span>
                        </div>
                        ${p.description ? `<div class="small text-muted mb-2"><i class="bi bi-justify-left me-1"></i>${p.description.substring(0, 60) + (p.description.length > 60 ? '...' : '')}</div>` : ''}
                        <div class="d-flex justify-content-end align-items-center mt-2 border-top pt-2">
                             <small class="text-primary fw-bold" style="font-size: 0.75rem;">View Details <i class="bi bi-arrow-right"></i></small>
                        </div>
                    </div>
                `;
            });
            listContainer.innerHTML = html;
        }

        // Slideshow Logic
        let currentSlide = 0;
        let projectImages = [];

        window.openProjectModal = function(projectId) {
            fetch(`/api/projects/${projectId}`)
                .then(r => r.json())
                .then(project => {
                    document.getElementById('modal-project-name').textContent = project.name;
                    document.getElementById('modal-state').textContent = project.state;
                    document.getElementById('modal-status').innerHTML = `<span class="status-badge status-${project.status}">${project.status}</span>`;
                    
                    const awardedRow = document.getElementById('modal-awarded-row');
                    if (project.awarded_at) {
                        const date = new Date(project.awarded_at);
                        document.getElementById('modal-awarded').textContent = date.toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' });
                        awardedRow.style.display = 'flex';
                    } else {
                        awardedRow.style.display = 'none';
                    }
                    
                    const descRow = document.getElementById('modal-description-row');
                    if (project.description && project.description.trim() !== '') {
                        document.getElementById('modal-description').textContent = project.description;
                        descRow.style.display = 'flex';
                    } else {
                        descRow.style.display = 'none';
                    }

                    // Setup Images
                    projectImages = project.images || [];
                    const wrapper = document.getElementById('slides-wrapper');
                    
                    if (projectImages.length > 0) {
                        currentSlide = 0;
                        renderSlide(0); 
                        renderDots(); // Generate dots
                        document.querySelector('.slide-nav-btn').parentElement.style.display = 'flex';
                    } else if (project.image) {
                        // Fallback partial support for old single image field
                         wrapper.innerHTML = `<div class="slide slide-fade" style="display:block"><img src="${project.image_url}" alt="${project.name}"></div>`;
                         document.getElementById('slide-dots').innerHTML = '';
                         document.querySelector('.slide-nav-btn').parentElement.style.display = 'none'; 
                    } else {
                        wrapper.innerHTML = `<div class="p-5 text-center text-white bg-secondary bg-opacity-25 rounded"><i class="bi bi-image display-4"></i><p class="mt-2">No images available</p></div>`;
                        document.getElementById('slide-dots').innerHTML = '';
                        document.querySelector('.slide-nav-btn').parentElement.style.display = 'none';
                    }

                    if (!myModal) {
                        try {
                            myModal = new bootstrap.Modal(document.getElementById('projectModal'));
                        } catch(e) {
                             console.error('Bootstrap modal init failed', e);
                            alert('Could not open project details. Please refresh the page.');
                            return;
                        }
                    }
                    myModal.show();
                })
                .catch(err => console.error('Error fetching project details:', err));
        };

    window.changeSlide = function(n) {
            currentSlide += n;
            if (currentSlide >= projectImages.length) currentSlide = 0;
            if (currentSlide < 0) currentSlide = projectImages.length - 1;
            renderSlide(n);
            updateDots();
        };

        window.goToSlide = function(index) {
            let direction = index > currentSlide ? 1 : -1;
            currentSlide = index;
            renderSlide(direction);
            updateDots();
        };

        function renderDots() {
            const dotsContainer = document.getElementById('slide-dots');
            if (projectImages.length <= 1) {
                dotsContainer.innerHTML = '';
                return;
            }
            let html = '';
            projectImages.forEach((_, idx) => {
                html += `<div class="dot ${idx === currentSlide ? 'active' : ''}" onclick="goToSlide(${idx})"></div>`;
            });
            dotsContainer.innerHTML = html;
        }

        function updateDots() {
            const dots = document.querySelectorAll('.dot');
            dots.forEach((dot, idx) => {
                if (idx === currentSlide) dot.classList.add('active');
                else dot.classList.remove('active');
            });
        }

        function renderSlide(direction = 0) {
            if (projectImages.length === 0) return;
            const img = projectImages[currentSlide];
            const wrapper = document.getElementById('slides-wrapper');
            
            // Determine animation class
            let animClass = 'slide-fade'; // Default for initial load
            if (direction > 0) animClass = 'slide-in-right';
            if (direction < 0) animClass = 'slide-in-left';

            wrapper.innerHTML = `
                <div class="slide ${animClass}" style="display:block;">
                    <img src="${img.image_url}" alt="Project Image">
                    ${img.caption ? `<div class="image-caption">${img.caption}</div>` : ''}
                </div>
            `;
        }
    </script>
</body>
</html>