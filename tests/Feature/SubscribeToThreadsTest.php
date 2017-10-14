<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscribeToThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_subscribe_to_threads()
    {
//        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

        $this->assertCount(1, $thread->fresh()->subscriptions);
    }

    /** @test */
    public function user_can_unsubscribe_from_threads()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscriptions');

        $this->assertDatabaseHas('thread_subscriptions', ['thread_id' => $thread->id]);

        $this->delete($thread->path() . '/subscriptions');

        $this->assertDatabaseMissing('thread_subscriptions', ['thread_id' => $thread->id]);

    }
}
