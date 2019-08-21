<?php

namespace Tests\Feature;

use App\Activity;
use App\Thread;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /**
     *
     */
    public function testIfActivityIsRecordedWhenThreadIsCreated()
    {
        $this->signIn();

        $thread = create('App\Thread');
        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => 'App\\Thread',
        ]);
        $activity = Activity::first();
        $this->assertEquals($activity->subject->id, $thread->id);
    }

    public function test_it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->assertEquals(2, Activity::count());
    }
    public function test_it_fetches_a_feed_for_user()
    {
//Given you have a thread
        $this->signIn();
        create(Thread::class, ['user_id' => auth()->id()]);
        //and other a week ago
        create(Thread::class, [
            'user_id' => auth()->id(),
            'created_at' => Carbon::now()->subWeek(),
        ]);
        //When we fetch users feed
        auth()->user()->activity()->first()->update([
            'created_at' => Carbon::now()->subWeek(),
        ]);
        $feed = Activity::feed(auth()->user());
        //then we get info properly formatted.
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));
    }
}
