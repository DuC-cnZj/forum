<?php

namespace Tests\Unit;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_has_an_owner()
    {
        $reply = create('App\Reply');

        $this->assertInstanceOf('App\User', $reply->owner);
    }
    
    /** @test */
    public function it_knows_it_was_just_published()
    {
        $reply = create('App\Reply');

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());

    }
    
    /** @test */
    public function it_can_detect_all_users_in_body()
    {
        $reply = new \App\Reply([
            'body' => '@duc @abc @fghjk',
        ]);

        $users = $reply->mentionedUsers();

        $this->assertEquals(['duc', 'abc', 'fghjk'], $users);
    }
    
    /** @test */
    public function it_warps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = new \App\Reply([
            'body' => 'hello @duc_duc.',
        ]);

        $this->assertEquals('hello <a href="/profiles/duc_duc">@duc_duc</a>.', $reply->body);
//        $users = $reply->mentionedUsers();
    }
}
