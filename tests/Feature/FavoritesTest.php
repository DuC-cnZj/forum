<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guests_can_not_favorite_anything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $this->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_a_reply()
    {
        $this->signIn();

        $reply = create('App\Reply');

        $reply->favorite();

        $this->delete('replies/' . $reply->id . '/favorites');

        $this->assertCount(0, $reply->favorites);
//        $this->assertDatabaseMissing('favorites', ['favorited_id' => $reply->id, 'user_id' => auth()->id()]);
    }

    /** @test */
    public function an_authenticated_user_can_only_favorite_a_reply_once()
    {
        $this->signIn();

        $reply = create('App\Reply');

        try {

            $this->post('replies/' . $reply->id . '/favorites');

            $this->post('replies/' . $reply->id . '/favorites');

        } catch (\Exception $e) {

            $this->fail('不能给一个回复点多次赞');
            
        }

        $this->assertCount(1, $reply->favorites);
    }

}
