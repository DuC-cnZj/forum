<?php

namespace Tests\Feature;

use App\Spam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_validates_spam()
    {
        $spam = new Spam;

        $this->assertFalse($spam->detect('duc'));
    }
}
