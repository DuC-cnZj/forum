<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MentionUsersTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $a = create('App\User', ['name' => 'aaa']);

        $this->signIn($a);

        $b = create('App\User', ['name' => 'bbb']);

        $thread = create('App\Thread');

        $reply = make('App\Reply', [
            'body' => '@bbb 阿特你 @fghj',
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $b->notifications);
    }
}
