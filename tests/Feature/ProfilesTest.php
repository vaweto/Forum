<?php
/**
 * Created by PhpStorm.
 * User: DevCave
 * Date: 7/25/2019
 * Time: 3:54 PM
 */

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_has_a_profile()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();

        $this->get('/profile/'.$user->name)
            ->assertSee($user->name);

    }

    /** @test */
    public function a_user_see_all_of_his_threads()
    {
        $this->withoutExceptionHandling();

        $user = factory('App\User')->create();

        $thread = factory('App\Thread')->create(['user_id' => $user->id]);

        $this->get('/profile/'.$user->name)
            ->assertSee($thread->title);
    }
}
