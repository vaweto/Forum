<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_browser_threads()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads');

        $response->assertStatus(200);

        $response->assertSee($thread->title);
    }

    /** @test */
    function a_user_can_browser_a_specific_threads()
    {
        $this->withoutExceptionHandling();
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads/' . $thread->id);

        $response->assertStatus(200);

        $response->assertSee($thread->title);
    }
}
