<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use App\Channel;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Throwable;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    protected $thread;

    public function setUp():void
    {
        parent::setUp();
        $this->thread = factory(Thread::class)->create();
    }
    public function test_thread_can_make_string_path()
    {
        $thread = create(Thread::class);
        $this->assertEquals('/threads/'. $thread->channel->slug.'/'.$thread->id, $thread->path());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHasReplies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    public function testThreadHasCreator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    public function testThreadCanAddReply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);
        $this->assertCount(1, $this->thread->replies);
    }
    public function test_thread_belongs_to_a_channel()
    {
        $thread =create(Thread::class);
        $this->assertInstanceOf(Channel::class, $thread->channel);
    }
}
