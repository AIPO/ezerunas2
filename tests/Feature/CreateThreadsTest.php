<?php

namespace Tests\Feature;

use App\Activity;
use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function testAuthenticatedUserCanCreateNewForumThreads()
    {
        //Create user
        $this->signIn();
        $thread = create(Thread::class);
        $response = $this->post('/threads', $thread->toArray());
        //dd($thread->path());
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function testGuestsMayNotCreateThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads')->assertRedirect('/login');
        $this->get('/threads/create')->assertRedirect('/login');
    }
    public function test_a_thread_requires_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors(['title']);
    }
    public function test_a_thread_requires_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors(['body']);
    }
    public function test_a_thread_requires_channel_id()
    {
        factory(Channel::class, 2)->create();
        $this->publishThread(['channel_id' => null])->assertSessionHasErrors(['channel_id']);
        $this->publishThread(['channel_id' => 2])->assertSessionHasErrors(['channel_id']);
    }
    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling();
        $this->expectException('Illuminate\Validation\ValidationException');
        $this->signIn();

        $thread = make(Thread::class, $overrides);
        //dd($thread);

        return $this->post('/threads', $thread->toArray());
    }
    public function testAuthorizedUsersThreadCanBeDeletedWithReplies()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        // $this->assertDatabaseMissing('activities', [
        //     'subject_id' => $thread->id,
        //     'subject_type' =>get_class($thread)
        // ]);
        // $this->assertDatabaseMissing('activities', [
        //     'subject_id' => $reply->id,
        //     'subject_type' =>get_class($reply)
        // ]);
      //  dd(Activity::count());
        $this->assertEquals(0, Activity::count());

    }
    /** @test */
    public function testUnauthorizedUsersCanNotDeleteThreads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = create(Thread::class);
        $this->delete($thread->path())->assertRedirect('/login');
        $this->signIn();
        $this->delete($thread->path())->assertRedirect('/login');
    }

}
