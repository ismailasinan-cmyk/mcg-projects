<div id="projects-table-container">
    @if($projects->count() > 0)
    <div class="table-responsive">
        <form id="bulk-form" action="{{ route('admin.projects.bulk-delete') }}" method="POST">
            @csrf
            <table class="table table-clean mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" style="width: 40px;">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                            </div>
                        </th>
                        <th style="width: 60px;">S/N</th>
                        <th>Project</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Date Awarded</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                        <tr class="project-row" data-id="{{ $project->id }}">
                            <td class="ps-4">
                                <div class="form-check">
                                    <input class="form-check-input project-checkbox" type="checkbox" name="ids[]" value="{{ $project->id }}">
                                </div>
                            </td>
                            <td class="fw-medium text-muted small">{{ $projects->firstItem() + $loop->index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3 position-relative">
                                        @if($project->images->count() > 0)
                                            <img src="{{ asset('storage/' . $project->images->first()->image_path) }}" alt="{{ $project->name }}"
                                                class="rounded-3 object-fit-cover shadow-sm border" style="width: 44px; height: 44px;">
                                        @elseif($project->image)
                                            <img src="{{ asset('storage/images/projects/' . $project->image) }}" alt="{{ $project->name }}"
                                                class="rounded-3 object-fit-cover shadow-sm border" style="width: 44px; height: 44px;">
                                        @else
                                            <div class="rounded-3 bg-light d-flex align-items-center justify-content-center text-muted border" style="width: 44px; height: 44px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0 lh-sm">{{ $project->name }}</div>
                                        <div class="text-muted small truncate-text d-none d-md-block" style="max-width: 300px;">{{ Str::limit($project->description, 60) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-secondary small fw-medium">{{ $project->state }}</td>
                            <td>
                                <span class="badge-status {{ $project->status }} px-2 py-1 rounded-pill small">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $project->awarded_at ? $project->awarded_at->format('M d, Y') : 'N/A' }}</td>
                            <td class="text-end pe-4">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-white border" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-white border text-danger" onclick="deleteProject({{ $project->id }})" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>

    <div class="px-4 py-3 border-top bg-light d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
        <small class="text-muted">Showing {{ $projects->firstItem() }} to {{ $projects->lastItem() }} of {{ $projects->total() }} projects</small>
        {{ $projects->links('vendor.pagination.custom') }}
    </div>
    @else
        <div class="text-center py-5">
            <div class="mb-3">
                <i class="bi bi-folder-x display-1 text-light"></i>
            </div>
            <h5 class="text-muted">No projects found</h5>
            <p class="text-muted small mb-4">Get started by creating a new project or adjusting your search.</p>
            <a href="{{ route('admin.projects.create') }}" class="btn btn-primary px-4 py-2">
                <i class="bi bi-plus-lg me-2"></i>Create Project
            </a>
        </div>
    @endif
</div>
