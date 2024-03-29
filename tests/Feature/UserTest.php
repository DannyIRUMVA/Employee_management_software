<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase; // Use RefreshDatabase instead of DatabaseTransactions

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test user registration.
     *
     * @return void
     */
    public function testUserRegistration()
    {
        $userData = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        $response = $this->json('POST', '/register', $userData);

        $response->assertStatus(200) // Corrected status code to 200
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'User is created successfully.',
                 ]);
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function testUserLogin()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->json('POST', '/login', $loginData);

        $response->assertStatus(200) // Corrected status code to 200
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'User is logged in successfully.',
                 ]);
    }

    /**
     * Test user logout.
     *
     * @return void
     */
    public function testUserLogout()
    {
        $user = User::factory()->create();
        $token = $user->createToken('TestToken')->plainTextToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->json('POST', '/logout');

        $response->assertStatus(200) // Corrected status code to 200
                 ->assertJson([
                     'status' => 'success',
                     'message' => 'User is logged out successfully',
                 ]);
    }

    /**
     * Test forgot password.
     *
     * @return void
     */
    public function testForgotPassword()
    {
        $userData = [
            'email' => 'test@example.com',
        ];

        $response = $this->json('POST', '/forgot-password', $userData);

        $response->assertStatus(200) // Corrected status code to 200
                 ->assertJson([
                     'message' => 'Password reset link sent successfully.',
                 ]);
    }
}
