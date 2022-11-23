<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventTestController extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_event_page()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('admin/events');
        $response->assertStatus(200);
    }
    public function test_create_event()
    {
        $user = User::factory()->create();
        $response = $this->post(route('admin.events.store'), [
            'title' => 'Test Event',
            'slug' => 'test-event',
            'description' => 'this is test event description',
            'start_date' => Date('Y-m-d'),
            'end_date' => Date('Y-m-d'),
            'user_id' => $user->id,
        ]);
        $response->assertRedirect();
    }
    public function test_update_event()
    {
        $user = User::factory()->create();
        $event = Event::create([
            'title' => 'Test Event',
            'slug' => 'test-event',
            'description' => 'this is test event description',
            'start_date' => Date('Y-m-d'),
            'end_date' => Date('Y-m-d'),
            'user_id' => $user->id,
        ]);
        $response = $this
            ->actingAs($user)
            ->from(route('admin.events.edit', $event->id))
            ->put(route('admin.events.update', $event->id), [
                'title' => 'Test Event 123',
                'slug' => 'test-event-123',
                'description' => 'this is test event 123 description',
                'start_date' => Date('Y-m-d'),
                'end_date' => Date('Y-m-d'),
                'user_id' => $user->id,
            ]);
        $response->assertRedirect();
    }

    public function test_delete_event()
    {
        $user = User::factory()->create();
        $event = Event::create([
            'title' => 'Test Event',
            'slug' => 'test-event',
            'description' => 'this is test event description',
            'start_date' => Date('Y-m-d'),
            'end_date' => Date('Y-m-d'),
            'user_id' => $user->id,
        ]);
        $response = $this
            ->actingAs($user)
            ->delete(route('admin.events.destroy', $event->id));
        $response->assertRedirect();
    }
}
