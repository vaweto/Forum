<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;
    public function setUp(): void
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    function it_has_replies()
    {
        $reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $this->assertInstanceOf('App\Reply', $this->thread->replies()->first());
    }

    /** @test */
    function it_belong_to_user()
    {

        $this->assertInstanceOf('App\User', $this->thread->owner);
    }

    /** @test */
    function it_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'foobar',
            'user_id'=> 1
        ]);

        $this->assertCount(1,$this->thread->replies);
        $this->assertDatabaseHas('replies', ['body'=>'foobar']);
    }
}
