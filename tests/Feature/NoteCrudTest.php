<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Note;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoteCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_list_update_and_delete_notes()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create
        $response = $this->post('/notes', [
            'title' => 'My First Note',
            'content' => 'Hello world',
        ]);
        $response->assertRedirect('/notes');
        $this->assertDatabaseHas('notes', ['title' => 'My First Note', 'user_id' => $user->id]);

        $note = Note::first();

        // List (pagination view exists)
        $response = $this->get('/notes');
        $response->assertStatus(200)->assertSee('My First Note');

        // Update
        $response = $this->put("/notes/{$note->id}", [
            'title' => 'Updated Title',
            'content' => 'Updated content',
        ]);
        $response->assertRedirect('/notes');
        $this->assertDatabaseHas('notes', ['id' => $note->id, 'title' => 'Updated Title']);

        // Delete
        $response = $this->delete("/notes/{$note->id}");
        $response->assertRedirect('/notes');
        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }

    /** @test */
    public function user_cannot_access_others_notes()
    {
        $alice = User::factory()->create();
        $bob   = User::factory()->create();
        $note  = Note::factory()->for($alice)->create();

        $this->actingAs($bob);

        $this->get("/notes/{$note->id}")->assertStatus(403);
        $this->get("/notes/{$note->id}/edit")->assertStatus(403);
        $this->put("/notes/{$note->id}", ['title' => 'x', 'content' => 'y'])->assertStatus(403);
        $this->delete("/notes/{$note->id}")->assertStatus(403);
    }
}

