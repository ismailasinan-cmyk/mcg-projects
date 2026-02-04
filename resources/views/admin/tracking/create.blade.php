@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1 letter-spacing-tight">New Tracking Entry</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tracking.index') }}" class="text-decoration-none">Tracking</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
        <div class="d-none d-md-block">
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-normal">
                <i class="bi bi-calendar3 me-2 text-muted"></i> {{ date('l, F j, Y') }}
            </span>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header border-bottom bg-white py-3 px-4">
                     <h5 class="mb-0 fw-bold text-dark">Entry Details</h5>
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

                    <form action="{{ route('admin.tracking.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" class="form-control bg-light border-0" id="date" name="date" value="{{ old('date') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="company" class="form-label">Company <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light border-0" id="company" name="company" value="{{ old('company', 'MCC') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="client" class="form-label">Client <span class="text-danger">*</span></label>
                                <input type="text" class="form-control bg-light border-0" id="client" name="client" value="{{ old('client') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="project" class="form-label">Project Title <span class="text-danger">*</span></label>
                            <textarea class="form-control bg-light border-0" id="project" name="project" rows="2" required>{{ old('project') }}</textarea>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="bg-light rounded-3 p-3 h-100">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-3">Location</label>
                                    
                                    <div class="mb-3">
                                        <label for="country" class="form-label small">Country <span class="text-danger">*</span></label>
                                        <select class="form-select border-0 shadow-none bg-white" id="country" name="country" onchange="toggleCountry(this)" required>
                                            <option value="Nigeria" selected>Nigeria</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                    
                                    <div id="state_wrapper" class="mb-3">
                                        <label for="state" class="form-label small">State</label>
                                        <select class="form-select border-0 shadow-none bg-white" id="state" name="state" onchange="loadLGAs(this)" required>
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                    
                                    <div id="lga_wrapper">
                                        <label for="lga" class="form-label small">LGA / City</label>
                                        <select class="form-select border-0 shadow-none bg-white" id="lga" name="lga">
                                            <option value="">Select LGA</option>
                                        </select>
                                    </div>

                                    <input type="text" class="form-control mt-2" id="state_input" name="state_text" style="display: none;" disabled placeholder="Enter State">
                                    <input type="text" class="form-control mt-2" id="lga_input" name="lga_text" style="display: none;" disabled placeholder="Enter LGA/City">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="bg-light rounded-3 p-3 h-100">
                                    <label class="form-label fw-bold small text-muted text-uppercase mb-3">Status & Cost</label>
                                    
                                    <div class="mb-3">
                                        <label for="status" class="form-label small">Current Status <span class="text-danger">*</span></label>
                                        <select class="form-select border-0 shadow-none bg-white" id="status" name="status" required>
                                            <option value="moving_forward" {{ old('status') == 'moving_forward' ? 'selected' : '' }}>Moving Forward</option>
                                            <option value="in_progress" {{ old('status', 'in_progress') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                            <option value="no_progress" {{ old('status') == 'no_progress' ? 'selected' : '' }}>No Progress</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="cost" class="form-label small">Project Cost (₦)</label>
                                        <div class="input-group bg-white rounded-3 overflow-hidden">
                                            <span class="input-group-text border-0 bg-transparent text-muted">₦</span>
                                            <input type="number" step="0.01" class="form-control border-0 shadow-none ps-1" id="cost" name="cost" value="{{ old('cost') }}" placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="activity" class="form-label">Current Activity</label>
                                <textarea class="form-control bg-light border-0" id="activity" name="activity" rows="3">{{ old('activity') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="progress" class="form-label">Progress Details</label>
                                <textarea class="form-control bg-light border-0" id="progress" name="progress" rows="3">{{ old('progress') }}</textarea>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="responsible" class="form-label">Person Responsible</label>
                            <div class="input-group">
                                <select class="form-select bg-light border-0" id="responsible_select" onchange="toggleResponsibleInput(this)">
                                    <option value="">Select Responsible Person</option>
                                    <option value="Dr. Nasir Usman Imam">Dr. Nasir Usman Imam</option>
                                    <option value="Mr. Ibrahim Usman Imam">Mr. Ibrahim Usman Imam</option>
                                    <option value="Engr. Abdulhakeem Ali">Engr. Abdulhakeem Ali</option>
                                    <option value="Dr. Sinan Ismaila Idris">Dr. Sinan Ismaila Idris</option>
                                    <option value="Aisha Usman">Aisha Usman</option>
                                    <option value="Ramatu Lawan">Ramatu Lawan</option>
                                    <option value="others">Other (Specify)</option>
                                </select>
                            </div>
                            <input type="text" class="form-control mt-2" id="responsible" name="responsible" value="{{ old('responsible') }}" style="display: none;" placeholder="Enter Name">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Upload Documents</label>
                            <div class="upload-zone p-4 rounded-3 border-dashed bg-light text-center mb-2">
                                <div id="document-upload-container">
                                    <div class="document-upload-row mb-2">
                                        <input type="file" name="documents[]" class="form-control" accept=".pdf,image/*">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addDocRow()">
                                    <i class="bi bi-plus-lg me-1"></i> Add Another Document
                                </button>
                                <p class="text-muted small mt-2 mb-0">Accepted: PDF and Images (JPG, PNG). Max 100MB.</p>
                            </div>
                        </div>

                        <div class="progress-container d-none mb-3">
                            <div class="progress shadow-sm" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 0%">0%</div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('admin.tracking.index') }}" class="btn btn-light border py-2 px-4 rounded-3">Cancel</a>
                            <button type="submit" class="btn btn-primary py-2 px-4 rounded-3 shadow-sm fw-bold">Save Entry</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        new FileUploadHandler('form', '.progress-bar', {
            redirectUrl: "{{ route('admin.tracking.index') }}"
        });

        // Initialize responsible select state
        var input = document.getElementById('responsible');
        var select = document.getElementById('responsible_select');
        
        if(input.value) {
            var found = false;
            for(var i=0; i<select.options.length; i++) {
                if(select.options[i].value === input.value) {
                    select.selectedIndex = i;
                    input.style.display = 'none';
                    found = true;
                    break;
                }
            }
            if(!found) {
                select.value = 'others';
                input.style.display = 'block';
            }
        }
        
        // Initialize country toggle state
        var countrySelect = document.getElementById('country');
        if(countrySelect) {
            toggleCountry(countrySelect);
        }
    });
</script>
@endsection