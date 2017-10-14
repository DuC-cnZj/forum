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

        $thread->addReply([
            'user_id' => auth()->id(),
            'body' => 'blablabla.'
        ]);

        $this->assertCount(1, auth()->user()->notifications);
//        $this->assertCount(1, $thread->subscriptions);
    }
}
