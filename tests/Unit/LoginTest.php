<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Factories\Factory;


use Illuminate\Foundation\Testing\DatabaseMigrations;


class LoginTest extends TestCase
{
    use RefreshDatabase,DatabaseMigrations;
    // $event = Event::factory()->create();

    /** @test */
    public function it_logs_in_a_user_with_valid_credentials()
    {
        // $user = User::factory()->create([
        //     'email' => 'john.doe@example.com',
        //     'password' => Hash::make('secret'),
        // ]);
        $user = User::create([
            
            'email' => 'john.doe@example.com',
            'password' => Hash::make('secret'),
        ]);

        $response = $this->json('post', '/login', [
            'email' => 'john.doe@example.com',
            'password' => 'secret',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token'
        ]);
    }

    /** @test */
    public function it_does_not_log_in_a_user_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => Hash::make('secret'),
        ]);

        $response = $this->json('post', '/login', [
            'email' => 'john.doe@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(400);
        $response->assertJson([
            'message' => 'The provided credentials are incorrect.'
        ]);
    }

    /** @test */
    public function it_logs_out_a_user()
    {
        $user = $this->User::factory()->create();
        $token = $user->createToken('device-name')->plainTextToken;

        $headers = [
            'Authorization' => "Bearer {$token}"
        ];

        $response = $this->json('post', '/logout', [], $headers);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Logged out successfully'
        ]);
    }
}
