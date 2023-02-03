<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    // public function it_returns_a_token_when_user_registers()
    // {
    //     $response = $this->json('post', route('register'), [
    //         'name' => 'John Doe',
    //         'email' => 'john.doe@example.com',
    //         'password' => 'secret'
    //     ]);
    
    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //         'token'
    //     ]);
    // }

    /** @test */
    public function it_validates_request_data_when_user_registers()
    {
        $response = $this->json('post', route('register'), [
            'name' => '',
            'email' => '',
            'password' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name', 'email', 'password'
        ]);
    }

    /** @test */
    public function it_stores_user_in_database_when_user_registers()
    {
        $this->json('post', route('register'), [
        'name' => 'John Doe',
        'email' => 'john.doe@example.com',
        'password' => 'secret'
    ]);

    $this->assertDatabaseHas('users', [
        'email' => 'john.doe@example.com',
        'name' => 'John Doe'
    ]);
    }
}
