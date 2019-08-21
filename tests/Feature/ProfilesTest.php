<?php
namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use DatabaseMigrations;
    public function testUserHasProfile()
    {
        $user = create(User::class);
        $this->get("/profiles/{$user->name}")->assertSee($user->name);
    }
    public function testProfilesDisplayAllthreadsCreatedByUser()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $this->get("/profiles/" . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
