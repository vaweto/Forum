<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->withoutExceptionHandling();

        $this->signIn(factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();

        $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    function an_non_authenticated_user_cannot_participate_in_forum_threads()
    {
        $this->withoutExceptionHandling()
            ->expectException('Illuminate\Auth\AuthenticationException');

        factory('App\User')->create();

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->create();

        $this->post('/threads/'.$thread->id.'/replies', $reply->toArray());

    }
}
