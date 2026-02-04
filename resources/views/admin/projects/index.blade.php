@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-3">
            <div>
                <h2 class="fw-bold text-dark mb-1 letter-spacing-tight">Projects</h2>
                <p class="text-muted mb-0">Manage and track your projects</p>
            </div>
            
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-white border shadow-sm hover-elevate text-dark">
                    <i class="bi bi-speedometer2 me-2 text-secondary"></i>Dashboard
                </a>
                <a href="{{ route('admin.tracking.index') }}" class="btn btn-white border shadow-sm hover-elevate text-dark">
                    <i class="bi bi-clipboard-data me-2 text-secondary"></i>Tracking Board
                </a>
                <a href="{{ route('admin.projects.create') }}" class="btn btn-primary shadow-sm hover-elevate">
                    <i class="bi bi-plus-lg me-2"></i>New Project
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-white py-3 px-4 border-bottom">
                <div class="row align-items-center g-3">
                    <div class="col-md-5">
                        <form action="{{ route('admin.projects.index') }}" method="GET" class="search-box d-flex gap-2">
                            <select name="status" class="form-select form-select-sm bg-light border-0" style="width: auto;" onchange="this.form.submit()">
                                <option value="all">All Status</option>
                                @foreach(config('options.project_status') as $value => $label)
                                    <option value="{{ $value }}" {{ (isset($status) && $status == $value) ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0 ps-3"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control bg-light border-start-0 ps-0" placeholder="Search..." value="{{ $searchTerm ?? '' }}">
                                <button class="btn btn-primary px-3" type="submit">Search</button>
                                @if((isset($searchTerm) && $searchTerm != '') || (isset($status) && $status != '' && $status != 'all'))
                                    <a href="{{ route('admin.projects.index') }}" class="btn btn-outline-secondary">Clear</a>
                                @endif
                            </div>
                        </form>
                    </div>
                    <div class="col-md-7 text-md-end d-flex justify-content-md-end align-items-center gap-2">
                        <div id="bulk-actions-container" class="d-none animate__animated animate__fadeIn">
                            <div class="btn-group btn-group-sm me-2 shadow-sm">
                                <button type="button" class="btn btn-danger" onclick="bulkDelete()">
                                    <i class="bi bi-trash me-1"></i> Delete Selected (<span id="selected-count">0</span>)
                                </button>
                                <button type="button" class="btn btn-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"></button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                    <li><h6 class="dropdown-header">Batch Operations</h6></li>
                                    <li><button class="dropdown-item text-danger" onclick="bulkDelete()"><i class="bi bi-trash-fill me-2"></i> Permanently Delete</button></li>
                                </ul>
                            </div>
                        </div>

                        <div class="btn-group btn-group-sm shadow-sm">
                            <a href="{{ route('admin.projects.export') }}" class="btn btn-white border">
                                <i class="bi bi-file-earmark-spreadsheet me-1"></i> Export
                            </a>
                            <button type="button" class="btn btn-white border" data-bs-toggle="modal" data-bs-target="#importModal">
                                <i class="bi bi-upload me-1"></i> Import
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-4" role="alert">
                        <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(isset($searchTerm) && $searchTerm != '')
                    <div class="alert alert-info m-4 border-0 bg-primary-soft text-primary">
                        <i class="bi bi-info-circle me-2"></i> Found <strong>{{ $projects->total() }}</strong> result{{ $projects->total() != 1 ? 's' : '' }} for <strong>"{{ $searchTerm }}"</strong>
                    </div>
                @endif

            <div class="card-body p-0" id="projects-index-container">
                @include('admin.projects._table')
            </div>

            </div>
        </div>
    </div>

    <!-- Import Modal (Consolidated) -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg p-2">
                <form action="{{ route('admin.projects.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Import CSV Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="upload-zone p-4 rounded-4 border-dashed mb-3 text-center bg-light">
                            <i class="bi bi-file-earmark-arrow-up display-5 text-primary mb-3 d-block"></i>
                            <label for="file" class="btn btn-sm btn-primary mb-2 rounded-pill px-4">Choose CSV File</label>
                            <input type="file" class="d-none" id="file" name="file" accept=".csv, .txt" required onchange="this.nextElementSibling.innerText = this.files[0].name">
                            <p class="text-muted small mb-0">Select a formatted CSV file to import.</p>
                        </div>
                        <div class="d-flex justify-content-between align-items-center bg-white border p-2 rounded-pill px-3 mb-3">
                            <span class="small text-muted">Reference: Name, State, Status, Description</span>
                            <a href="{{ route('admin.projects.template') }}" class="btn btn-link btn-sm text-decoration-none p-0 fw-bold">Template</a>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 px-4 pb-4">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm">Start Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function deleteProject(projectId) {
            confirmDelete(() => {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/projects/${projectId}`;
                form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                document.body.appendChild(form);
                form.submit();
            });
        }
    </script>

    <style>
        .border-dashed { border: 2px dashed #dee2e6; }
        .truncate-text { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
        .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
        .btn-white { background: #fff; }
        .hover-elevate:hover { transform: translateY(-2px); transition: transform 0.2s; }
        .project-row.table-active { background-color: rgba(13, 110, 253, 0.05) !important; }
    </style>
@endsection
