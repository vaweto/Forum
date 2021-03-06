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

        $response = $this->get($this->thread->path());

        $response->assertStatus(200);

        $response->assertSee($this->thread->title);
    }

    /** @test */
    function a_user_can_see_replies_on_threads()
    {
        $this->withoutExceptionHandling();

        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get($this->thread->path());

        $response->assertStatus(200);

        $response->assertSee($reply->body);
    }

    /** @test */
    function a_user_can_see_thread_owner_name_on_thread_page()
    {
        $this->withoutExceptionHandling();

        $response = $this->get( $this->thread->path());

        $response->assertStatus(200);

        $response->assertSee($this->thread->owner->name);
    }

    /** @test */
    function a_user_can_filter_threads_according_to_a_tag()
    {
        $channel = factory('App\Channel')->create();
        $threadInChannel = factory('App\Thread')->create( ['channel_id' => $channel->id]);

        $threadNotInChannel = make('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $other_thread = create('App\Thread');

        $this->get('/threads/?by=JohnDoe' )
            ->assertSee($threadByJohn->title)
            ->assertDontSee($other_thread->title);
    }

    /** @test */
    function a_user_can_filter_test_by_popularity()
    {
        $threadWithTwoReplies = factory('App\Thread',1)->create();
        factory('App\Reply',2)->create(['thread_id' => $threadWithTwoReplies->first()->id]);


        $threadWithThreeReplies = factory('App\Thread',1)->create();
        factory('App\Reply',3)->create(['thread_id' => $threadWithThreeReplies->first()->id]);

        $response = $this->getJson('threads?popular=1')->json();

        $this->assertEquals([3,2,0], array_column($response,'replies_count'));
     }
}
