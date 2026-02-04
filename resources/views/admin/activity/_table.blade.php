<div id="activity-table-container">
    <div class="table-responsive">
        <table class="table table-clean mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">Time</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Subject</th>
                    <th>IP Address</th>
                    <th class="text-end pe-4">Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                <tr>
                    <td class="ps-4">
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-dark">{{ $activity->created_at->format('M d, Y') }}</span>
                            <span class="text-muted small">{{ $activity->created_at->format('H:i:s') }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="avatar-sm me-2 bg-primary-soft text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold small" style="width: 32px; height: 32px;">
                                {{ strtoupper(substr($activity->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <span class="fw-medium">{{ $activity->user->name ?? 'System' }}</span>
                        </div>
                    </td>
                    <td>
                        @php
                            $badgeClass = match($activity->action) {
                                'create' => 'bg-success-soft text-success',
                                'update' => 'bg-warning-soft text-warning',
                                'delete' => 'bg-danger-soft text-danger',
                                default => 'bg-info-soft text-info'
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }} border-0 px-2 py-1 rounded-pill small fst-italic">
                            {{ strtoupper($activity->action) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex flex-column">
                            <span class="fw-medium">{{ class_basename($activity->subject_type) }}</span>
                            <span class="text-muted small">ID: #{{ $activity->subject_id }}</span>
                        </div>
                    </td>
                    <td>
                        <code class="text-muted small bg-light px-2 py-1 rounded">{{ $activity->ip_address }}</code>
                    </td>
                    <td class="text-end pe-4">
                        <button class="btn btn-sm btn-light border rounded-pill px-3" type="button" data-bs-toggle="collapse" data-bs-target="#details-{{ $activity->id }}">
                            View
                        </button>
                    </td>
                </tr>
                <tr class="border-0">
                    <td colspan="6" class="p-0 border-0">
                        <div class="collapse" id="details-{{ $activity->id }}">
                            <div class="bg-light p-4 border-top border-bottom border-light">
                                <h6 class="fw-bold mb-3 small text-muted text-uppercase tracking-wider">Activity Details</h6>
                                <p class="mb-3">{{ $activity->description }}</p>
                                
                                @if($activity->changes)
                                <div class="bg-white rounded-3 border p-3">
                                    <pre class="mb-0 overflow-auto small" style="max-height: 200px;"><code>{{ json_encode($activity->changes, JSON_PRETTY_PRINT) }}</code></pre>
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5">
                        <div class="text-muted mb-2">
                            <i class="bi bi-clock-history fs-1 opacity-25"></i>
                        </div>
                        <p class="mb-0">No activity recorded yet.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($activities->hasPages())
    <div class="card-footer bg-white border-0 py-3">
        {{ $activities->appends(['search' => request('search'), 'action' => request('action')])->links('vendor.pagination.custom') }}
    </div>
    @endif
</div>
