<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect(route('login'));

        $this->post(route('threads'))
            ->assertRedirect(route('login'));

//        $this->expectException('Illuminate\Auth\AuthenticationException');
//
//        $thread = make('App\Thread');
//
//        $this->post(route('threads, $thread->toArray());
    }

    /** @test */
    public function new_user_can_crate_new_forum_thread()
    {
        // 给我一个登陆的用户
//        $this->actingAs(factory('App\User')->create());

        $this->signIn();

        // 点击发表评论 raw() 返回数组
//        $thread = factory('App\Thread')->raw();
        $thread = make('App\Thread');

        $response = $this->post(route('threads'), $thread->toArray());
//        dd($response->headers->get('Location'));
        // 可以看到 thread page
        $response = $this->get($response->headers->get('Location'));

        // 可以看到评论内容
        $response->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        create('App\Channel', ['id' => 2]);

        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()
            ->signIn();

        $thread = make('App\Thread', $overrides);

//        dd($thread);

        return $this->post(route('threads'), $thread->toArray());
    }

    /** @test */
    public function unauthenticated_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();
        $thread = create('App\Thread');

        $this->delete($thread->path())
            ->assertRedirect(route('login'));

        $this->signIn();

        $this->delete($thread->path())
            ->assertStatus(403);

    }

    /** @test */
    public function authenticated_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id()]);

        $reply = create('App\Reply', ['thread_id' => $thread->id]);

        $this->json('DELETE', $thread->path())
            ->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);

        $this->assertDatabaseMissing('activities', [
            'subject_id'   => $thread->id,
            'subject_type' => get_class($thread),
        ]);

        $this->assertDatabaseMissing('activities', [
            'subject_id'   => $reply->id,
            'subject_type' => get_class($reply),
        ]);

        $this->assertEquals(0, Activity::count());
    }

    /** @test */
    public function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();

        $this->signIn($user);

        $thread = make('App\Thread');

        $this->post(route('threads'), $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', '请先验证邮箱。');
    }
//    /** @test */
//    public function threads_can_only_be_deleted_by_those_who_has_permission()
//    {
//
//    }

//    /** @test */
//    public function guests_can_not_see_threads_page()
//    {
//        $this->withExceptionHandling()
//            ->get('/threads/create')
//            ->assertRedirect(route('login'));
//    }
}
