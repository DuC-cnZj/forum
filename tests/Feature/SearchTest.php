<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function a_user_can_search_threads()
    {
        config(['scout.driver' => 'algolia']);

        $search = 'ducong';
        create('App\Thread', [], 2);
        create('App\Thread', ['body' => "a thread with {$search} term."], 2);

        do {
            $results = $this->getJson("/threads/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(2, $results);

        Thread::latest()->take(4)->unsearchable();
    }
}
