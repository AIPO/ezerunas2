<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAuthenticatedUserCanParticipateInForumThreads()
    {
        // user is authenticated
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class);
        $this->post($thread->path() . '/replies', $reply->toArray());
        //on threads/thread id see reply
        $this->get($thread->path())->assertSee($reply->body);
    }

    /**
     *
     */
    public function testUnauthenticatedUsersMayNotAddReplies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('threads/some-channel/1/replies', []);
    }
    public function test_a_reply_requires_body()
    {
        $this->signIn()
            ->expectException('Illuminate\Validation\ValidationException');
        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);
        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertSessionHasErrors('body');
    }
    public function test_unauthorized_users_cannot_delete_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $reply = create(Reply::class);
        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');
        $this->signIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }
    public function test_authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        $this->delete("/replies/{$reply->id}");
      //  $this->assertStatus(302);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
    public function test_authorized_users_can_update_replies()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        $this->patch("/replies/{$reply->id}", ['body'=> 'body is updated']);
        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body'=> 'body is updated']);
    }
}
