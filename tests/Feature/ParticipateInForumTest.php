<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->withExceptionHandling()
            ->post('/threads/channel/1/replies', [])
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\User')->create());
//        $user = factory('App\User')->create();

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->assertDatabaseHas('replies', ['body' => $reply->body]);

        $this->assertEquals(1, $thread->fresh()->replies_count);
//        $this->assertEquals(0, $thread->fresh()->replies_count);
        // 因为是 javascript 所以测试无法找到，可以通过 database 来判断
//        $this->get($thread->path())
//            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->publishReply(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function publishReply($overrides = [])
    {
        $this->withExceptionHandling()
            ->signIn();

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make($overrides);

        $this->post($thread->path() . '/replies', $reply->toArray());


        return $this->post($thread->path() . 'replies', $reply->toArray());
    }

    /** @test */
    public function unauthenticated_users_cannot_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->delete("replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->delete("replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authenticated_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $this->delete("replies/{$reply->id}")->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertEquals(0, $reply->thread->fresh()->replies_count);
    }

    /** @test */
    public function authenticated_users_can_update_replies()
    {
        $this->signIn();
        $reply = create('App\Reply', ['user_id' => auth()->id()]);

        $updateReply = 'you are changed!';

        $this->patch("replies/{$reply->id}", ['body' => $updateReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updateReply]);
    }

    /** @test */
    public function unauthenticated_users_cannot_update_replies()
    {
        $this->withExceptionHandling();

        $reply = create('App\Reply');

        $this->patch("replies/{$reply->id}")
            ->assertRedirect('/login');

        $this->signIn()
            ->patch("replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function replies_that_contain_spam_may_not_be_created()
    {
        $this->be($user = factory('App\User')->create());
//        $user = factory('App\User')->create();

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make([
            'body' => 'Yahoo..',
        ]);

        $this->post($thread->path() . '/replies', $reply->toArray())
            ->assertStatus(422);

    }
}
