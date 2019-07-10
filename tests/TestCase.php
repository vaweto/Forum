<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function signIn($user = null)
    {
        if($user) {
            $this->actingAs($user);
        }else{
            $user = factory('App\User')->create();
            $this->actingAs($user);
        }
    }
}
