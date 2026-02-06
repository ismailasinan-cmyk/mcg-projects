@extends('layouts.app')

@push('styles')
<style>
    .apexcharts-canvas {
        margin: 0 auto;
    }
</style>
@endpush

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold text-dark mb-1 letter-spacing-tight">Dashboard Overview</h2>
                <p class="text-muted mb-0">System performance and project distribution</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary px-4 rounded-3 shadow-sm">
                    <i class="bi bi-plus-lg me-2"></i>New Project
                </a>
                <button type="button" class="btn btn-dark px-4 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-upload me-2"></i>Import
                </button>
            </div>
        </div>

        <!-- Top Row: Charts -->
        <div class="row g-4 mb-4">
            <!-- Project Creation Bar Chart -->
            <div class="col-lg-9">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white py-2 px-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-calendar-check me-2 text-primary"></i>Projects by Year</h6>
                    </div>
                    <div class="card-body p-2">
                        <div id="yearChart" style="min-height: 180px;"></div>
                    </div>
                </div>
            </div>
            <!-- Status Distribution -->
            <div class="col-lg-3">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white py-2 px-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pie-chart me-2 text-info"></i>Status Mix</h6>
                    </div>
                    <div class="card-body p-2 d-flex align-items-center justify-content-center">
                        <div id="statusChart" style="min-height: 180px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Second Row: Key Stats -->
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="card stats-card card-info h-100 shadow-sm rounded-4 border-0">
                    <div class="card-body p-2 d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted text-uppercase fw-bold x-small letter-spacing-wide d-block mb-1" style="font-size: 0.65rem;">Operational Projects</span>
                            <h3 class="fw-bold text-dark mb-0">{{ $operationalProjects }}</h3>
                        </div>
                        <div class="icon-box bg-info-soft text-info rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-lightning-charge-fill fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stats-card card-success h-100 shadow-sm rounded-4 border-0">
                    <div class="card-body p-2 d-flex align-items-center">
                        <div class="flex-grow-1">
                            <span class="text-muted text-uppercase fw-bold x-small letter-spacing-wide d-block mb-1" style="font-size: 0.65rem;">Completion Rate</span>
                            <h3 class="fw-bold text-dark mb-0">
                                @if($totalProjects > 0)
                                    {{ round(($completedProjects / $totalProjects) * 100) }}<small class="fs-6">%</small>
                                @else
                                    0<small class="fs-6">%</small>
                                @endif
                            </h3>
                        </div>
                        <div class="icon-box bg-success-soft text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-graph-up-arrow fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Projects -->
        <div class="card shadow-sm border-0 rounded-4 card-recent-projects overflow-hidden mb-5">
            <div class="card-header border-bottom bg-white py-3 px-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <h5 class="mb-0 fw-bold text-dark">Recent Activity</h5>
                <div class="d-flex align-items-center gap-3">
                    <form action="{{ route('admin.dashboard') }}" method="GET" class="search-box">
                        <div class="input-group input-group-sm shadow-sm" style="width: 250px;">
                            <span class="input-group-text bg-light border-end-0 ps-3"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" placeholder="Search projects..." value="{{ $searchTerm ?? '' }}">
                            <button class="btn btn-primary px-3" type="submit">Search</button>
                        </div>
                    </form>
                    <a href="{{ route('admin.projects.index') }}" class="btn btn-sm btn-link text-decoration-none p-0 fw-bold">View All <i class="bi bi-arrow-right ms-1"></i></a>
                </div>
            </div>
            
            <div class="card-body p-0" id="dashboard-projects-container">
                @include('admin.dashboard._projects')
            </div>
        </div>
    </div>

    <!-- Import Modal (Unchanged functional logic, updated style) -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <form action="{{ route('admin.projects.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0 pb-0 px-4 pt-4">
                        <h5 class="modal-title fw-bold" id="importModalLabel">Import Projects</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4 text-center">
                            <div class="upload-zone p-4 rounded-3 border-dashed mb-3" style="border: 2px dashed #dee2e6; background: #f8f9fa;">
                                <i class="bi bi-file-earmark-spreadsheet display-4 text-muted mb-3 d-block"></i>
                                <label for="file" class="btn btn-sm btn-primary mb-2">Choose CSV File</label>
                                <input type="file" class="d-none" id="file" name="file" accept=".csv, .txt" required onchange="this.nextElementSibling.innerText = this.files[0].name">
                                <p class="text-muted small mb-0">No file chosen</p>
                            </div>
                            <div class="small text-muted">
                                Required columns: Name, State, Status, Description
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 px-4 pb-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Import Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let statusChart, yearChart;

        function initCharts() {
            const isDark = document.documentElement.getAttribute('data-bs-theme') === 'dark';
            const themeMode = isDark ? 'dark' : 'light';

            // Status Distribution Chart
            var statusOptions = {
                series: [{{ $ongoingProjects }}, {{ $completedProjects }}, {{ $suspendedProjects }}, {{ $operationalProjects }}],
                chart: {
                    type: 'donut',
                    height: 350,
                    background: 'transparent'
                },
                theme: {
                    mode: themeMode
                },
                labels: ['Ongoing', 'Completed', 'Suspended', 'Operational'],
                colors: ['#ffc107', '#198754', '#dc3545', '#0dcaf0'],
                legend: {
                    position: 'bottom',
                    labels: {
                        colors: isDark ? '#f8fafc' : '#334155'
                    }
                },
                stroke: {
                    show: true,
                    colors: isDark ? ['#1e293b'] : ['#fff']
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'Total',
                                    color: isDark ? '#94a3b8' : '#64748b',
                                    formatter: function (w) {
                                        return w.globals.seriesTotals.reduce((a, b) => a + b, 0)
                                    }
                                },
                                value: {
                                    color: isDark ? '#f8fafc' : '#334155'
                                }
                            }
                        }
                    }
                }
            };

            if (statusChart) statusChart.destroy();
            statusChart = new ApexCharts(document.querySelector("#statusChart"), statusOptions);
            statusChart.render();

            // Yearly Bar Chart
            var yearOptions = {
                series: [{
                    name: 'Projects Created',
                    data: [
                        @foreach($projectsByYearData as $data)
                            {{ $data->count }},
                        @endforeach
                    ]
                }],
                chart: {
                    height: 350,
                    type: 'bar',
                    background: 'transparent',
                    toolbar: {
                        show: false
                    }
                },
                theme: {
                    mode: themeMode
                },
                colors: ['#0d6efd'],
                plotOptions: {
                    bar: {
                        borderRadius: 10,
                        columnWidth: '50%',
                    }
                },
                dataLabels: {
                    enabled: false
                },
                grid: {
                    borderColor: isDark ? 'rgba(255,255,255,0.05)' : '#f1f1f1'
                },
                xaxis: {
                    categories: [
                        @foreach($projectsByYearData as $data)
                            '{{ $data->year }}',
                        @endforeach
                    ],
                    labels: {
                        style: {
                            colors: isDark ? '#94a3b8' : '#64748b'
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: isDark ? '#94a3b8' : '#64748b'
                        }
                    }
                }
            };

            if (yearChart) yearChart.destroy();
            yearChart = new ApexCharts(document.querySelector("#yearChart"), yearOptions);
            yearChart.render();
        }

        initCharts();

        window.addEventListener('themeChanged', function() {
            initCharts();
        });
    });
</script>
@endpush
