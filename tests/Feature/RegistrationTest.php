<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function a_confirmation_email_sent_upon_registration()
    {
        Mail::fake();

//        event(new Registered(create('App\User')));
        $this->post(route('register'), [
            'name'                  => 'test',
            'email'                 => '10254@qqc.c',
            'password'              => 'foobar',
            'password_confirmation' => 'foobar',
        ]);


        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    /** @test */
    function user_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();
        
        $this->post(route('register'), [
            'name'                  => 'test',
            'email'                 => '10254@qqc.c',
            'password'              => 'foobar',
            'password_confirmation' => 'foobar',
        ]);

        $user = User::whereName('test')->first();

        $this->assertFalse($user->confirmed);

        $this->assertNotNull($user->confirmation_token);

        $this->get(route('register.confirm', ['token' => $user->confirmation_token]))
            ->assertRedirect(route('threads'));

        $this->assertTrue($user->fresh()->confirmed);
    }
    
    /** @test */
    function confirming_an_invalid_token()
    {
        $this->get(route('register.confirm', ['token' => 'invalid']))
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', '邮箱验证失败。');

    }
}
