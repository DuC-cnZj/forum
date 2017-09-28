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

        $this->post('/threads', $thread->toArray());
        // 可以看到 thread page
        $response = $this->get($thread->path());

        // 可以看到评论内容
        $response->assertSee($thread->title)
            ->assertSee($thread->body);
    }

//    /** @test */
//    public function guests_can_not_see_threads_page()
//    {
//        $this->withExceptionHandling()
//            ->get('/threads/create')
//            ->assertRedirect('/login');
//    }
}
