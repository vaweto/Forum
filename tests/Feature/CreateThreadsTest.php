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
    function an_authenticated_user_can_delete_his_own_thread()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->signIn($user);

        $thread = factory('App\Thread')->create(['user_id' => $user->id]);

        $this->delete($thread->path());

        $this->assertDatabaseMissing('threads',['id' => $thread->id]);
    }

    /** @test */
    function when_thread_deleted_delete_all_his_replies()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();
        $this->signIn($user);

        $thread = factory('App\Thread')->create(['user_id' => $user->id]);
        $reply = factory('App\Reply')->create(['thread_id' => $thread->id]);

        $response = $this->delete( $thread->path());

        $this->assertDatabaseMissing('replies',['id' => $reply->id]);
    }

    /** @test */
    function an_authenticated_user_cannot_delete_other_owners_thread()
    {
        $user = factory('App\User')->create();

        $thread = factory('App\Thread')->create(['user_id' => $user->id]);

        $this->signIn(factory('App\User')->create());

        $this->delete($thread->path());

        $this->assertDatabaseHas('threads',['id' => $thread->id]);
    }

    /** @test */
    function an_non_user_cannot_delete_his_own_thread()
    {
        $user = factory('App\User')->create();

        $thread = factory('App\Thread')->create(['user_id' => $user->id]);

        $this->json('Delete', $thread->path());

        $this->assertDatabaseHas('threads',['id' => $thread->id]);
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
