<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        Cache::flush();
    }

    /** @test */
    public function public_can_view_map_page()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertViewIs('map');
    }

    /** @test */
    public function public_can_get_project_statistics()
    {
        Project::factory()->count(3)->create(['status' => 'ongoing']);
        Project::factory()->count(2)->create(['status' => 'completed']);

        $response = $this->getJson('/api/projects/statistics');

        $response->assertStatus(200)
            ->assertJson([
                'total' => 5,
                'ongoing' => 3,
                'completed' => 2,
            ]);
    }

    /** @test */
    public function admin_can_view_dashboard()
    {
        $response = $this->actingAs($this->user)
            ->withoutExceptionHandling()
            ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function admin_can_create_project_with_images()
    {
        Storage::fake('public');

        $projectData = [
            'name' => 'New Test Project',
            'state' => 'Lagos',
            'status' => 'ongoing',
            'description' => 'Test project description',
            'images' => [
                UploadedFile::fake()->image('project1.jpg'),
                UploadedFile::fake()->image('project2.jpg')
            ],
            'captions' => ['First view', 'Second view']
        ];

        $response = $this->actingAs($this->user)
            ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
            ->post(route('admin.projects.store'), $projectData);

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', ['name' => 'New Test Project']);

        $project = Project::where('name', 'New Test Project')->first();
        $this->assertCount(2, $project->images);
    }

    /** @test */
    public function admin_can_update_project()
    {
        $project = Project::factory()->create(['name' => 'Old Name']);

        $response = $this->actingAs($this->user)
            ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
            ->put(route('admin.projects.update', $project), [
                'name' => 'Updated Name',
                'state' => $project->state,
                'status' => 'completed',
            ]);

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'name' => 'Updated Name',
            'status' => 'completed'
        ]);
    }

    /** @test */
    public function admin_can_delete_project()
    {
        $project = Project::factory()->create();

        $response = $this->actingAs($this->user)
            ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class])
            ->delete(route('admin.projects.destroy', $project));

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }

    /** @test */
    public function admin_can_filter_projects_by_search_term()
    {
        Project::factory()->create(['name' => 'Solar Power Initiative']);
        Project::factory()->create(['name' => 'Wind Farm Project']);

        $response = $this->actingAs($this->user)
            ->get(route('admin.projects.index', ['search' => 'Solar']));

        $response->assertStatus(200);
        $response->assertSee('Solar Power Initiative');
        $response->assertDontSee('Wind Farm Project');
    }

    /** @test */
    public function admin_can_filter_projects_by_status()
    {
        Project::factory()->create(['name' => 'Ongoing Pj', 'status' => 'ongoing']);
        Project::factory()->create(['name' => 'Completed Pj', 'status' => 'completed']);

        $response = $this->actingAs($this->user)
            ->get(route('admin.projects.index', ['status' => 'ongoing']));

        $response->assertStatus(200);
        $response->assertSee('Ongoing Pj');
        $response->assertDontSee('Completed Pj');
    }

    /** @test */
    public function admin_can_upload_project_files_via_ajax()
    {
        Storage::fake('public');

        $projectData = [
            'name' => 'Ajax Project',
            'state' => 'Abuja',
            'status' => 'ongoing',
            'description' => 'Test',
            'images' => [UploadedFile::fake()->image('test.jpg')],
        ];

        $response = $this->actingAs($this->user)
            ->postJson(route('admin.projects.store'), $projectData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Project created successfully!',
                'redirect' => route('admin.projects.index')
            ]);
    }
}
