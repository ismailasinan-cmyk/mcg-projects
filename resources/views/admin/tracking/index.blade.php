@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold text-dark mb-1 letter-spacing-tight">Project Tracking</h2>
                <p class="text-muted mb-0">Monitor and manage project progress and details</p>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <div class="d-none d-md-block me-2">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal">
                        <i class="bi bi-calendar3 me-2 text-muted"></i> {{ date('l, F j, Y') }}
                    </span>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-white border px-4 py-2 rounded-3 hover-elevate text-dark">
                    <i class="bi bi-speedometer2 me-2 text-secondary"></i>Dashboard
                </a>
                <button type="button" class="btn btn-white border px-4 py-2 rounded-3 hover-elevate text-dark" data-bs-toggle="modal" data-bs-target="#importModal">
                    <i class="bi bi-upload me-2 text-secondary"></i>Import
                </button>
                <a href="{{ route('admin.tracking.export', ['search' => $searchTerm, 'status' => $statusFilter, 'state' => $stateFilter]) }}" class="btn btn-white border px-4 py-2 rounded-3 hover-elevate text-dark">
                    <i class="bi bi-download me-2 text-secondary"></i>Export
                </a>
                <a href="{{ route('admin.tracking.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm hover-elevate">
                    <i class="bi bi-plus-lg me-2"></i>New Entry
                </a>
            </div>
        </div>

        <!-- Filters -->
        <div class="card mb-4 shadow-sm border-0 rounded-4">
            <div class="card-body p-3">
                <form action="{{ route('admin.tracking.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 border"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control bg-light border-start-0 border" placeholder="Search project, client..." value="{{ $searchTerm ?? '' }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="state" class="form-select bg-light border">
                            <option value="">All States</option>
                            @foreach(config('options.states') as $state)
                                <option value="{{ $state }}" {{ $stateFilter == $state ? 'selected' : '' }}>{{ $state }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select bg-light border">
                            <option value="">All Status</option>
                            @foreach(config('options.tracking_status') as $value => $label)
                                <option value="{{ $value }}" {{ $statusFilter == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-dark rounded-3" type="submit">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Data Card -->
        <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0" id="tracking-index-container">
                @include('admin.tracking._table')
            </div>

            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <form action="{{ route('admin.tracking.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" id="importModalLabel">Import Tracking Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-4 text-center">
                            <div class="upload-zone p-4 rounded-3 border-dashed mb-3">
                                <i class="bi bi-file-earmark-spreadsheet display-4 text-muted mb-3 d-block"></i>
                                <label for="file" class="btn btn-sm btn-primary mb-2">Choose CSV File</label>
                                <input type="file" class="d-none" id="file" name="file" accept=".csv, .txt" required onchange="this.nextElementSibling.innerText = this.files[0].name">
                                <p class="text-muted small mb-0">No file chosen</p>
                            </div>
                            <div class="small text-muted">
                                Format: Date, Company, Client, Project, Country, State, LGA, Cost, Activity, Progress, Responsible, Status
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <a href="{{ route('admin.tracking.template') }}" class="text-decoration-none small fw-bold">
                                <i class="bi bi-download me-1"></i> Download Sample Template
                            </a>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0 px-4 pb-4">
                        <button type="button" class="btn btn-light text-muted" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary px-4">Import Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function deleteTracking(id) {
            confirmDelete(() => {
                document.getElementById('delete-form-' + id).submit();
            });
        }

        function previewDocument(event, url, filename, docId) {
            event.preventDefault();

            // Set title and download link
            document.getElementById('previewModalTitle').innerText = filename;
            document.getElementById('previewDownloadBtn').href = url;
            document.getElementById('previewDownloadBtn').download = filename; // Suggest filename
            
            // Set delete form action
            const deleteForm = document.getElementById('previewDeleteForm');
            deleteForm.action = `/admin/tracking/document/${docId}`; // Using hardcoded path structure to avoid passing full route
            
            const body = document.getElementById('previewModalBody');
            body.innerHTML = '<div class="d-flex justify-content-center align-items-center h-100"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>';

            // Show modal
            var myModal = new bootstrap.Modal(document.getElementById('documentPreviewModal'));
            myModal.show();

            // Determine content based on extension
            const extension = filename.split('.').pop().toLowerCase();
            let content = '';

            const imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
            
            if (imageExtensions.includes(extension)) {
                content = `<div class="p-3 text-center"><img src="${url}" class="img-fluid rounded shadow-sm" style="max-height: 75vh;" alt="${filename}"></div>`;
            } else if (extension === 'pdf') {
                content = `<iframe src="${url}" style="width: 100%; height: 80vh; border: none;"></iframe>`;
            } else {
                content = `
                    <div class="text-center p-5">
                        <i class="bi bi-file-earmark-text display-1 text-muted mb-3 opacity-25"></i>
                        <h5 class="text-muted">Preview not available</h5>
                        <p class="mb-4 text-muted small">This file type (${extension}) cannot be previewed directly in the browser.</p>
                        <a href="${url}" class="btn btn-primary px-4 rounded-pill" download="${filename}">
                            <i class="bi bi-download me-2"></i>Download File
                        </a>
                    </div>
                `;
            }

            // Small delay to allow modal transition to start smoothly
            setTimeout(() => {
                body.innerHTML = content;
            }, 200);
        }
    </script>

    <!-- Document Preview Modal -->
    <div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content rounded-4 border-0 shadow-lg" style="max-height: 90vh;">
                <div class="modal-header border-bottom py-3 px-4">
                    <h5 class="modal-title fw-bold text-truncate pe-3" id="previewModalTitle">Document Preview</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 bg-light" id="previewModalBody" style="min-height: 400px;">
                    <!-- Content injected via JS -->
                </div>
                <div class="modal-footer border-top py-3 px-4 bg-white justify-content-between">
                    <div>
                        <form id="previewDeleteForm" method="POST" onsubmit="event.preventDefault(); confirmDelete(() => this.submit());">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger px-4 rounded-pill">
                                <i class="bi bi-trash me-2"></i>Delete
                            </button>
                        </form>
                    </div>
                    <div>
                        <a href="#" id="previewDownloadBtn" class="btn btn-primary px-4 rounded-pill">
                            <i class="bi bi-download me-2"></i>Download
                        </a>
                        <button type="button" class="btn btn-light text-muted px-4 rounded-pill border" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
