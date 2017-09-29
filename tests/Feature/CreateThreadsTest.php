<?php

namespace Tests\Feature;

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
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');

//        $this->expectException('Illuminate\Auth\AuthenticationException');
//
//        $thread = make('App\Thread');
//
//        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function an_authenticated_user_can_crate_new_forum_thread()
    {
        // 给我一个登陆的用户
//        $this->actingAs(factory('App\User')->create());

        $this->signIn();

        // 点击发表评论 raw() 返回数组
//        $thread = factory('App\Thread')->raw();
        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());
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

        return $this->post('/threads', $thread->toArray());
    }

//    /** @test */
//    public function guests_can_not_see_threads_page()
//    {
//        $this->withExceptionHandling()
//            ->get('/threads/create')
//            ->assertRedirect('/login');
//    }
}
