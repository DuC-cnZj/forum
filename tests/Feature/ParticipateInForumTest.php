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

        $this->get($thread->path())
            ->assertSee($reply->body);
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
}
