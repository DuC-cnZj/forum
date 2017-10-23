<?php

namespace Tests\Feature;

use App\Inspections\Spam;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SpamTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_checks_for_invalid_keywords()
    {
        $spam = new Spam;

        $this->assertFalse($spam->detect('take me away'));

        $this->expectException('Exception');

        $spam->detect('艹');
    }
    
    /** @test */
    public function it_check_any_key_being_hold_down()
    {
        $spam = new Spam;

        $this->expectException('Exception');

        $spam->detect('hello world aaaaaaaaaaa');
    }
}
