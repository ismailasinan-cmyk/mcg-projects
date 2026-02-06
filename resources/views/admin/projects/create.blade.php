@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1 letter-spacing-tight">Create Project</h2>
            <p class="text-muted mb-0">Add a new project to the system</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-light border text-muted hover-elevate shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to Projects
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-info-circle me-2 text-primary"></i>Project Details</h5>
                </div>
                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-danger rounded-3 mb-4">
                            <ul class="mb-0 small">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4 mb-4">
                            <div class="col-lg-8">
                                <label for="name" class="form-label text-muted small fw-bold text-uppercase">Project Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Infrastructure Development Phase 1" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for="awarded_at" class="form-label text-muted small fw-bold text-uppercase">Date Awarded</label>
                                <input type="date" class="form-control form-control-lg bg-light border-0 @error('awarded_at') is-invalid @enderror" 
                                       id="awarded_at" name="awarded_at" value="{{ old('awarded_at', date('Y-m-d')) }}">
                                @error('awarded_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="state" class="form-label text-muted small fw-bold text-uppercase">State <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg bg-light border-0 @error('state') is-invalid @enderror" id="state" name="state" required>
                                    <option value="">Select State</option>
                                    @foreach($states as $state)
                                        <option value="{{ $state }}" {{ old('state') == $state ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="status" class="form-label text-muted small fw-bold text-uppercase">Status <span class="text-danger">*</span></label>
                                <select class="form-select form-select-lg bg-light border-0 @error('status') is-invalid @enderror" id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    @foreach($statusOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label text-muted small fw-bold text-uppercase">Description</label>
                            <textarea class="form-control bg-light border-0 @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" placeholder="Enter detailed project description here...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase mb-3">Project Images (Max 10)</label>
                            
                            <div id="image-upload-container">
                                <div class="image-upload-row card border-dashed mb-3 p-3 bg-light">
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-5">
                                            <input type="file" name="images[]" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this)">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" name="captions[]" class="form-control form-control-sm" placeholder="Image caption (optional)">
                                        </div>
                                        <div class="col-md-1 text-end">
                                            <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="removeImageRow(this)" style="display:none;">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="image-preview mt-3 text-center" style="display:none;">
                                        <img src="" alt="Preview" class="img-thumbnail rounded-3" style="max-height: 150px;">
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-outline-primary btn-sm dashed-button w-100 py-2" onclick="addImageRow()">
                                <i class="bi bi-plus-lg me-1"></i> Add Another Image
                            </button>
                            <div class="form-text mt-2 small text-muted"><i class="bi bi-info-circle me-1"></i> Supported: JPG, PNG, GIF. Max 2MB each (Total 10MB).</div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <div class="progress-container d-none mb-3">
                            <div class="progress shadow-sm" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-light border">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Create Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-lightbulb me-2 text-warning"></i>Tips</h5>
                </div>
                <div class="card-body p-4">
                    <ul class="list-unstyled mb-0 d-flex flex-column gap-3">
                        <li class="d-flex align-items-start text-muted">
                            <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                            <span>Use a clear, descriptive <strong>project name</strong>.</span>
                        </li>
                        <li class="d-flex align-items-start text-muted">
                            <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                            <span>Ensure the <strong>state</strong> matches the project location.</span>
                        </li>
                        <li class="d-flex align-items-start text-muted">
                            <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                            <span><strong>Status</strong> helps track progress on the dashboard.</span>
                        </li>
                        <li class="d-flex align-items-start text-muted">
                            <i class="bi bi-check-circle-fill text-success me-2 mt-1"></i>
                            <span>Upload high-quality <strong>images</strong> to showcase progress.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new FileUploadHandler('form', '.progress-bar', {
            redirectUrl: "{{ route('admin.projects.index') }}"
        });
    });

    let imageCount = 1;
    const maxImages = 10;

    function addImageRow() {
        if (imageCount >= maxImages) {
            alert('Maximum ' + maxImages + ' images allowed');
            return;
        }
        
        const container = document.getElementById('image-upload-container');
        const newRow = document.createElement('div');
        newRow.className = 'image-upload-row card border-dashed mb-3 p-3 bg-light fade-in';
        newRow.innerHTML = `
            <div class="row align-items-center g-3">
                <div class="col-md-5">
                    <input type="file" name="images[]" class="form-control form-control-sm" accept="image/*" onchange="previewImage(this)">
                </div>
                <div class="col-md-6">
                    <input type="text" name="captions[]" class="form-control form-control-sm" placeholder="Image caption (optional)">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm border-0" onclick="removeImageRow(this)">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>
            <div class="image-preview mt-3 text-center" style="display:none;">
                <img src="" alt="Preview" class="img-thumbnail rounded-3" style="max-height: 150px;">
            </div>
        `;
        container.appendChild(newRow);
        imageCount++;
    }

    function removeImageRow(btn) {
        const row = btn.closest('.image-upload-row');
        if (row) {
            row.remove();
            imageCount--;
        }
    }

    function previewImage(input) {
        const row = input.closest('.image-upload-row');
        const preview = row.querySelector('.image-preview');
        const img = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.style.display = 'none';
        }
    }
</script>
<style>
    .dashed-button {
        border-style: dashed !important;
        border-width: 2px !important;
    }
    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
