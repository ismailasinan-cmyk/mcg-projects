<?php

namespace Tests\Feature;

use App\Models\ProjectTracking;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectTrackingTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function admin_can_view_tracking_index()
    {
        $tracking = ProjectTracking::factory()->create();

        $response = $this->actingAs($this->user)
            ->get(route('admin.tracking.index'));

        $response->assertStatus(200);
        $response->assertSee($tracking->project);
    }

    /** @test */
    public function admin_can_create_tracking_entry_via_ajax()
    {
        Storage::fake('public');

        $data = ProjectTracking::factory()->raw([
            'country' => 'Nigeria',
            'state' => 'Lagos',
            'documents' => [UploadedFile::fake()->create('contract.pdf')],
        ]);

        $response = $this->actingAs($this->user)
            ->postJson(route('admin.tracking.store'), $data);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Project tracking created successfully!',
                'redirect' => route('admin.tracking.index')
            ]);
        
        $this->assertDatabaseHas('project_trackings', ['project' => $data['project']]);
    }

    /** @test */
    public function admin_can_filter_tracking_entries()
    {
        ProjectTracking::factory()->create(['project' => 'Alpha Project', 'status' => 'in_progress']);
        ProjectTracking::factory()->create(['project' => 'Beta Project', 'status' => 'no_progress']);

        // Search
        $response = $this->actingAs($this->user)
            ->get(route('admin.tracking.index', ['search' => 'Alpha']));
        $response->assertSee('Alpha Project');
        $response->assertDontSee('Beta Project');

        // Filter Status
        $response = $this->actingAs($this->user)
            ->get(route('admin.tracking.index', ['status' => 'in_progress']));
        $response->assertSee('Alpha Project');
        $response->assertDontSee('Beta Project');
    }

    /** @test */
    public function admin_can_delete_tracking_entry()
    {
        $tracking = ProjectTracking::factory()->create();

        $response = $this->actingAs($this->user)
            ->delete(route('admin.tracking.destroy', $tracking));

        $response->assertRedirect(route('admin.tracking.index'));
        $this->assertDatabaseMissing('project_trackings', ['id' => $tracking->id]);
    }
}
