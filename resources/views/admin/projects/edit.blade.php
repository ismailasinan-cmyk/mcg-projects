@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1 letter-spacing-tight">Edit Project</h2>
            <p class="text-muted mb-0">Update information for #{{ $project->id }}</p>
        </div>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-light border text-muted hover-elevate shadow-sm">
            <i class="bi bi-arrow-left me-2"></i>Back to Projects
        </a>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-primary"></i>Project Details</h5>
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

                    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row g-4 mb-4">
                            <div class="col-lg-8">
                                <label for="name" class="form-label text-muted small fw-bold text-uppercase">Project Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-lg bg-light border-0 @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $project->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-4">
                                <label for="awarded_at" class="form-label text-muted small fw-bold text-uppercase">Date Awarded</label>
                                <input type="date" class="form-control form-control-lg bg-light border-0 @error('awarded_at') is-invalid @enderror" 
                                       id="awarded_at" name="awarded_at" value="{{ old('awarded_at', $project->awarded_at ? $project->awarded_at->format('Y-m-d') : '') }}">
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
                                        <option value="{{ $state }}" {{ old('state', $project->state) == $state ? 'selected' : '' }}>
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
                                        <option value="{{ $value }}" {{ old('status', $project->status) == $value ? 'selected' : '' }}>
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
                                      id="description" name="description" rows="5">{{ old('description', $project->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Images -->
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase mb-3">Current Images</label>
                            @if($project->images->count() > 0)
                                <div class="row g-3" id="current-images">
                                    @foreach($project->images as $image)
                                        <div class="col-md-4 col-sm-6" id="image-card-{{ $image->id }}">
                                            <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden">
                                                <div class="position-relative">
                                                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                                                        class="card-img-top object-fit-cover" 
                                                        style="height: 140px; width: 100%;">
                                                    <div class="position-absolute top-0 end-0 p-2">
                                                        <div class="form-check form-check-reverse">
                                                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" 
                                                                class="form-check-input bg-danger border-danger" id="delete_{{ $image->id }}"
                                                                onchange="toggleImageDelete(this)">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body p-2 bg-light">
                                                    <p class="small text-muted mb-1 text-truncate">{{ $image->caption ?? 'No caption' }}</p>
                                                    <label class="small text-danger cursor-pointer fw-bold" for="delete_{{ $image->id }}">
                                                        Delete
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-light text-center border-0 small text-muted">No images uploaded yet.</div>
                            @endif
                        </div>

                        <!-- Add New Images -->
                        <div class="mb-4">
                            <label class="form-label text-muted small fw-bold text-uppercase mb-3">Add New Images</label>
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
                            <div class="form-text mt-2 small text-muted"><i class="bi bi-info-circle me-1"></i> Supported: JPG, PNG, GIF. Max 100MB each.</div>
                        </div>

                        <hr class="text-muted opacity-25 my-4">

                        <div class="progress-container d-none mb-3">
                            <div class="progress shadow-sm" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.projects.index') }}" class="btn btn-light border">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Update Project</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-info-circle me-2 text-info"></i>Project Info</h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold d-block">Created At</label>
                        <span class="text-dark">{{ $project->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small text-uppercase fw-bold d-block">Last Updated</label>
                        <span class="text-dark">{{ $project->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div>
                        <label class="text-muted small text-uppercase fw-bold d-block">Total Images</label>
                        <span class="text-dark">{{ $project->images->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 rounded-4 border-top-danger overflow-hidden">
                <div class="card-header bg-danger-subtle py-3 px-4 border-bottom border-danger-subtle">
                    <h5 class="mb-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-3">Permanently delete this project and all its associated data. This action cannot be undone.</p>
                    <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this project? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="bi bi-trash me-2"></i>Delete Project
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new FileUploadHandler('form[action*="update"]', '.progress-container .progress-bar', {
            redirectUrl: "{{ route('admin.projects.index') }}"
        });

        window.imageCount = 1;
        window.maxImages = 10;
    });

    function toggleImageDelete(checkbox) {
        const card = checkbox.closest('.card');
        const img = card.querySelector('img');
        
        if (checkbox.checked) {
            card.classList.add('border-danger');
            img.style.opacity = '0.5';
            img.style.filter = 'grayscale(100%)';
        } else {
            card.classList.remove('border-danger');
            img.style.opacity = '1';
            img.style.filter = 'none';
        }
    }

    function addImageRow() {
        if (window.imageCount >= window.maxImages) {
            alert('Maximum ' + window.maxImages + ' images allowed');
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
        window.imageCount++;
    }

    function removeImageRow(btn) {
        const row = btn.closest('.image-upload-row');
        if (row) {
            row.remove();
            window.imageCount--;
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
    .border-top-danger {
        border-top: 3px solid #dc3545 !important;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush
@endsection