<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($user)
    {
        if($user) {
            $this->actingAs($user);
        }else{
            $user = factory('App\User')->create();
            $this->actingAs($user);
        }
    }
}
