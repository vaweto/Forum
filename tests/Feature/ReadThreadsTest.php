<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp() : void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    function a_user_can_browser_threads()
    {

        $response = $this->get('/threads');

        $response->assertStatus(200);

        $response->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_browser_a_specific_threads()
    {
        $this->withoutExceptionHandling();

        $response = $this->get('/threads/' . $this->thread->id);

        $response->assertStatus(200);

        $response->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_see_replies_on_threads()
    {
        $this->withoutExceptionHandling();

        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get('/threads/' .  $this->thread->id);

        $response->assertStatus(200);

        $response->assertSee($reply->body);
    }
}
