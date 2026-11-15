<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_page_loads(): void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function test_successful_registration(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'nis' => '1234567890',
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Berhasil membuat akun! Silahkan login.');

        $this->assertDatabaseHas('ms_user', [
            'username' => 'testuser',
            'email' => 'testuser@example.com',
            'nis' => '1234567890',
            'role' => 'siswa',
        ]);

        $user = User::where('email', 'testuser@example.com')->first();
        $this->assertTrue(password_verify('SecurePass123!', $user->password));
    }

    public function test_registration_requires_username(): void
    {
        $response = $this->post('/register', [
            'email' => 'test@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'nis' => '1234567890',
        ]);

        $response->assertSessionHasErrors('username');
    }

    public function test_registration_requires_email(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'nis' => '1234567890',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_registration_requires_password(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password_confirmation' => 'SecurePass123!',
            'nis' => '1234567890',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_requires_password_confirmation(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'SecurePass123!',
            'nis' => '1234567890',
        ]);

        $response->assertSessionHasErrors('password_confirmation');
    }

    public function test_registration_password_must_match_confirmation(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'DifferentPass123!',
            'nis' => '1234567890',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_registration_duplicate_email_fails(): void
    {
        User::factory()->create(['email' => 'existing@example.com']);

        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'existing@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'nis' => '1234567890',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_registration_duplicate_username_fails(): void
    {
        User::factory()->create(['username' => 'existinguser']);

        $response = $this->post('/register', [
            'username' => 'existinguser',
            'email' => 'test@example.com',
            'password' => 'SecurePass123!',
            'password_confirmation' => 'SecurePass123!',
            'nis' => '1234567890',
        ]);

        $response->assertSessionHasErrors('username');
    }

    public function test_registration_password_min_length(): void
    {
        $response = $this->post('/register', [
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => 'short',
            'password_confirmation' => 'short',
            'nis' => '1234567890',
        ]);

        $response->assertSessionHasErrors('password');
    }
}
