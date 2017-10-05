<?php

namespace Tests\Feature;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_a_thread_created()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->assertDatabaseHas('activities', [
            'type'         => 'created_thread',
            'user_id'      => auth()->id(),
            'subject_id'   => $thread->id,
            'subject_type' => get_class($thread),
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function it_records_activity_a_reply_created()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->assertEquals(2, Activity::count());
//        $this->assertDatabaseHas('activities', [
//            'type' => 'created_reply',
//            'user_id' => auth()->id(),
//            'subject_id' => $reply->id,
//            'subject_type' => get_class($reply),
//        ]);
//
//        $activity = Activity::first();
//
//        $this->assertEquals($activity->subject->id, $reply->id);
    }
    
    /** @test */
    public function it_fetchs_activities_for_any_user()
    {
        $this->signIn();

        create('App\Thread', ['user_id' => auth()->id()], 2);

        auth()->user()->activities()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user(), 50);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('y-m-d')
//            Carbon::now()->subWeek()->format('y-m-d'),
        ));

        $this->assertTrue($feed->keys()->contains(
//            Carbon::now()->format('y-m-d')
            Carbon::now()->subWeek()->format('y-m-d')
        ));
    }
}
