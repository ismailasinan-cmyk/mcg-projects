<div id="dashboard-projects-table">
    <div class="table-responsive">
        <table class="table table-clean mb-0 align-middle">
            <thead class="bg-light">
                <tr>
                    <th class="ps-4">S/N</th>
                    <th>Project Name</th>
                    <th>State</th>
                    <th>Status</th>
                    <th>Date Awarded</th>
                    <th class="text-end pe-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($projects as $project)
                    <tr>
                        <td class="ps-4 fw-medium text-muted">{{ $projects->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $project->name }}</div>
                        </td>
                        <td>{{ $project->state }}</td>
                        <td>
                            <span class="badge-status {{ $project->status }}">
                                {{ ucfirst($project->status) }}
                            </span>
                        </td>
                        <td>{{ $project->awarded_at ? $project->awarded_at->format('M d, Y') : 'N/A' }}</td>
                        <td class="text-end pe-4">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-light border-0 rounded-circle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-three-dots-vertical text-muted"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3">
                                    <li><a class="dropdown-item" href="{{ route('admin.projects.edit', $project) }}"><i class="bi bi-pencil me-2"></i> Edit</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure?')"><i class="bi bi-trash me-2"></i> Delete</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($projects->hasPages())
        <div class="px-4 py-3 border-top bg-light">
            {{ $projects->links('vendor.pagination.custom') }}
        </div>
    @endif
</div>
