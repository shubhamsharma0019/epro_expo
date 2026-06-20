<?php

namespace Tests\Feature;

use App\Domain\Admin\Models\Admin;
use App\Domain\Event\Models\Exhibition;
use App\Domain\Event\Models\Hall;
use App\Domain\Event\Models\Pavilion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPavilionHallEditTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;
    protected Exhibition $exhibition;
    protected Pavilion $pavilion;
    protected Hall $hall;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = Admin::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'status' => 'active',
            'role' => 'admin',
        ]);

        $this->exhibition = Exhibition::create([
            'title' => 'Global Tech Expo 2024',
            'slug' => 'global-tech-expo-2024',
            'start_date' => '2026-06-12',
            'end_date' => '2026-06-14',
            'status' => 'active',
            'approval_status' => 'approved',
            'publish_status' => 'published',
        ]);

        $this->pavilion = Pavilion::create([
            'exhibition_id' => $this->exhibition->id,
            'title' => 'Innovation Pavilion',
            'slug' => 'innovation-pavilion',
            'status' => 'active',
            'total_halls' => 0,
            'total_booths' => 0,
        ]);

        $this->hall = Hall::create([
            'pavilion_id' => $this->pavilion->id,
            'title' => 'Hall 1 - AI Solutions',
            'slug' => 'hall-1-ai-solutions',
            'status' => 'active',
            'total_booths' => 0,
        ]);
    }

    public function test_admin_can_edit_and_update_pavilion(): void
    {
        // Authenticate admin via session
        $this->session(['admin_id' => $this->admin->id]);

        // 1. Visit Pavilion List
        $response = $this->get(route('admin.pavilions.index'));
        $response->assertStatus(200);
        $response->assertSee('Innovation Pavilion');
        $response->assertSee(route('admin.pavilions.edit', $this->pavilion->id));

        // 2. Visit Edit Pavilion Form
        $response = $this->get(route('admin.pavilions.edit', $this->pavilion->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Pavilion');
        $response->assertSee('Innovation Pavilion');

        // 3. Submit Update request
        $response = $this->put(route('admin.pavilions.update', $this->pavilion->id), [
            'exhibition_id' => $this->exhibition->id,
            'title' => 'Updated Pavilion Title',
            'status' => 'inactive',
            'description' => 'New Description Text',
        ]);

        $response->assertRedirect(route('admin.pavilions.index'));
        $response->assertSessionHas('status', 'Pavilion updated successfully.');

        // 4. Assert DB update
        $this->pavilion->refresh();
        $this->assertEquals('Updated Pavilion Title', $this->pavilion->title);
        $this->assertEquals('updated-pavilion-title', $this->pavilion->slug);
        $this->assertEquals('inactive', $this->pavilion->status);
        $this->assertEquals('New Description Text', $this->pavilion->description);

        // 5. Assert audit log exists
        $this->assertDatabaseHas('admin_activity_logs', [
            'action' => 'pavilion_updated',
            'subject_type' => 'pavilion',
            'subject_id' => $this->pavilion->id,
        ]);
    }

    public function test_admin_can_edit_and_update_hall(): void
    {
        // Authenticate admin via session
        $this->session(['admin_id' => $this->admin->id]);

        // 1. Visit Hall List
        $response = $this->get(route('admin.halls.index'));
        $response->assertStatus(200);
        $response->assertSee('Hall 1 - AI Solutions');
        $response->assertSee(route('admin.halls.edit', $this->hall->id));

        // 2. Visit Edit Hall Form
        $response = $this->get(route('admin.halls.edit', $this->hall->id));
        $response->assertStatus(200);
        $response->assertSee('Edit Hall');
        $response->assertSee('Hall 1 - AI Solutions');

        // 3. Submit Update request
        $response = $this->put(route('admin.halls.update', $this->hall->id), [
            'pavilion_id' => $this->pavilion->id,
            'title' => 'Updated Hall Title',
            'status' => 'inactive',
            'description' => 'New Hall Description',
        ]);

        $response->assertRedirect(route('admin.halls.index'));
        $response->assertSessionHas('status', 'Hall updated successfully.');

        // 4. Assert DB update
        $this->hall->refresh();
        $this->assertEquals('Updated Hall Title', $this->hall->title);
        $this->assertEquals('updated-hall-title', $this->hall->slug);
        $this->assertEquals('inactive', $this->hall->status);
        $this->assertEquals('New Hall Description', $this->hall->description);

        // 5. Assert audit log exists
        $this->assertDatabaseHas('admin_activity_logs', [
            'action' => 'hall_updated',
            'subject_type' => 'hall',
            'subject_id' => $this->hall->id,
        ]);
    }
}
