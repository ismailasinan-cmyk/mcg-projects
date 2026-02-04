@extends('layouts.app')

@section('header_title', 'Activity Log')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overlay-card">
                <div class="card-header bg-white py-3 border-bottom border-light d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title fw-bold mb-0">System Activity Timeline</h5>
                        <p class="text-muted small mb-0">Monitor all administrative actions and project changes.</p>
                    </div>
                </div>
                
                <div class="card-body p-3 border-bottom bg-light">
                    <form action="{{ route('admin.activity.index') }}" method="GET" class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 border"><i class="bi bi-search text-muted"></i></span>
                                <input type="text" name="search" class="form-control bg-white border-start-0 border" placeholder="Search activity, user..." value="{{ $searchTerm ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <select name="action" class="form-select bg-white border">
                                <option value="">All Actions</option>
                                <option value="create" {{ ($actionFilter ?? '') == 'create' ? 'selected' : '' }}>Create</option>
                                <option value="update" {{ ($actionFilter ?? '') == 'update' ? 'selected' : '' }}>Update</option>
                                <option value="delete" {{ ($actionFilter ?? '') == 'delete' ? 'selected' : '' }}>Delete</option>
                                <option value="login" {{ ($actionFilter ?? '') == 'login' ? 'selected' : '' }}>Login</option>
                            </select>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button class="btn btn-dark rounded-3" type="submit">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="card-body p-0" id="activity-index-container">
                    @include('admin.activity._table')
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
    .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
    .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
    .bg-info-soft { background-color: rgba(13, 202, 240, 0.1); }
    .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
    
    .table-clean tbody tr:not(.border-0):hover {
        background-color: rgba(0,0,0,0.01);
    }
    
    .tracking-wider { letter-spacing: 0.05em; }
</style>
@endsection
