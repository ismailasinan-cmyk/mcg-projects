<?php

namespace Tests\Feature;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityLogTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function admin_can_view_activity_logs()
    {
        $log = ActivityLog::factory()->create(['description' => 'User logged in']);

        $response = $this->actingAs($this->user)
            ->get(route('admin.activity.index'));

        $response->assertStatus(200);
        $response->assertSee('User logged in');
    }

    /** @test */
    public function admin_can_filter_activity_logs()
    {
        ActivityLog::factory()->create(['description' => 'Created Pj', 'action' => 'create']);
        ActivityLog::factory()->create(['description' => 'Updated Pj', 'action' => 'update']);

        // Search
        $response = $this->actingAs($this->user)
            ->get(route('admin.activity.index', ['search' => 'Created']));
        $response->assertSee('Created Pj');
        $response->assertDontSee('Updated Pj');

        // Filter Action
        $response = $this->actingAs($this->user)
            ->get(route('admin.activity.index', ['action' => 'update']));
        $response->assertSee('Updated Pj');
        $response->assertDontSee('Created Pj');
    }
}
