<div id="tracking-table-container">
    @if($trackings->count() > 0)
    <div class="table-responsive">
        <table class="table table-clean mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">S/N</th>
                    <th>Date</th>
                    <th>Project Details</th>
                    <th>Location</th>
                    <th>Cost</th>
                    <th>Progress</th>
                    <th>Responsible</th>
                    <th>Documents</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($trackings as $index => $tracking)
                    <tr class="hover-bg-light">
                        <td class="ps-4 fw-medium text-muted">{{ $trackings->firstItem() + $index }}</td>
                        <td class="text-muted small">{{ $tracking->date ? $tracking->date->format('M d, Y') : '-' }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $tracking->project }}</div>
                            <div class="small text-muted">
                                <i class="bi bi-building me-1"></i>{{ $tracking->company }}
                                <span class="mx-1">•</span>
                                <i class="bi bi-person me-1"></i>{{ $tracking->client }}
                            </div>
                        </td>
                        <td>
                            <div class="text-dark">{{ $tracking->state }}</div>
                            @if($tracking->lga)
                                <div class="small text-muted">{{ $tracking->lga }}</div>
                            @endif
                        </td>
                        <td class="fw-medium text-dark">{{ $tracking->cost ? '₦' . number_format($tracking->cost, 2) : '-' }}</td>
                        <td style="min-width: 200px;">
                            @if($tracking->activity)
                                <div class="small text-dark mb-1"><strong>Activity:</strong> {{ $tracking->activity }}</div>
                            @endif
                            @if($tracking->progress)
                                <div class="small text-muted"><strong>Progress:</strong> {{ $tracking->progress }}</div>
                            @endif
                        </td>
                        <td class="small">{{ $tracking->responsible ?? '-' }}</td>
                        <td>
                            @if($tracking->documents->count() > 0)
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-light border rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                                        <i class="bi bi-paperclip me-1"></i> {{ $tracking->documents->count() }}
                                    </button>
                                    <ul class="dropdown-menu shadow border-0 rounded-3">
                                        @foreach($tracking->documents as $doc)
                                            <li>
                                                <a class="dropdown-item d-flex align-items-center" 
                                                   href="{{ asset($doc->file_path) }}" 
                                                   onclick="previewDocument(event, '{{ asset($doc->file_path) }}', '{{ $doc->file_name }}', {{ $doc->id }})">
                                                    <i class="{{ $doc->icon }} me-2 text-primary"></i> 
                                                    <div>
                                                        <div class="small">{{ Str::limit($doc->file_name, 20) }}</div>
                                                        <div class="text-muted" style="font-size: 10px;">{{ $doc->file_size }}</div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-status {{ $tracking->status }}">
                                {{ config('options.tracking_status')[$tracking->status] ?? $tracking->status }}
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border-0 rounded-circle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('admin.tracking.edit', $tracking) }}">
                                            <i class="bi bi-pencil me-2 text-primary"></i> Edit Details
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button type="button" class="dropdown-item text-danger" onclick="deleteTracking({{ $tracking->id }})">
                                            <i class="bi bi-trash me-2"></i> Delete Entry
                                        </button>
                                    </li>
                                </ul>
                            </div>
                            <form id="delete-form-{{ $tracking->id }}" action="{{ route('admin.tracking.destroy', $tracking) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="px-4 py-3 border-top bg-light d-flex justify-content-between align-items-center">
        <small class="text-muted">Showing {{ $trackings->firstItem() }}-{{ $trackings->lastItem() }} of {{ $trackings->total() }} entries</small>
        @if($trackings->hasPages())
            <div>
                {{ $trackings->appends(['search' => $searchTerm, 'status' => $statusFilter, 'state' => $stateFilter])->links('vendor.pagination.custom') }}
            </div>
        @endif
    </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-clipboard-x display-4 text-light"></i>
            </div>
            <h5 class="text-muted fw-normal">No tracking entries found</h5>
            <p class="text-muted small mb-4">Try adjusting your search filters or create a new entry.</p>
            <a href="{{ route('admin.tracking.create') }}" class="btn btn-primary px-4 rounded-3 shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>Add First Entry
            </a>
        </div>
    @endif
</div>
