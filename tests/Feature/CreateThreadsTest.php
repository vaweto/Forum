<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
   use RefreshDatabase;

   /** @test */
   function an_authenticated_user_can_create_new_forum_thread()
    {
        $this->signIn(factory('App\User')->create());

        $thread = make('App\Thread');

        $this->post('/threads',$thread->toArray());

        $this->assertDatabaseHas('threads', ['title' => $thread->title]);
    }

    /** @test */
    function an_not_authenticated_may_not_create_new_forum_thread()
    {
        $this->withoutExceptionHandling()
            ->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory('App\Thread')->make();

        $this->post('/threads',$thread->toArray());

        $this->assertDatabaseMissing('threads', ['title' => $thread->title]);
    }

    /** @test */
    function a_guest_cannot_see_the_create_threads_page()
    {
        $this->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    function a_guest_can_see_the_index_threads()
    {
        $this->get('/threads')
            ->assertStatus(200);
    }

    /** @test */
    function a_thread_requires_a_title()
    {
        $this->signIn();

        $thread = make('App\Thread', ['title' => null]);

        $this->post('/threads', $thread->toArray())
            ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_requires_a_body()
    {
        $this->signIn();

        $thread = make('App\Thread', ['body' => null]);

        $this->post('/threads', $thread->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function a_thread_requires_a_channel()
    {
        $this->signIn();

        factory('App\Channel', 2)->create();

        $thread = make('App\Thread', ['channel_id' => null]);

        $this->post('/threads', $thread->toArray())
            ->assertSessionHasErrors('channel_id');

        $thread = make('App\Thread', ['channel_id' => 999]);

        $this->post('/threads', $thread->toArray())
            ->assertSessionHasErrors('channel_id');
    }
}
