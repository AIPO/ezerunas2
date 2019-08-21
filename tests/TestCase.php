<?php

namespace Tests;

use App\User;
use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp():void
    {
        parent::setUp();
      //  $this->disableExceptionHandling();
    }

    protected function signIn($user = null)
    {
        if ($user) {
            $user = $user;
        } else {
            $user = create(User::class);
        }
        $this->actingAs($user);
        return $this;
    }
    
}
