<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     */
    public function test_the_application_returns_a_successful_response(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_legacy_bcrypt_passwords_can_sign_in_and_are_rehashed(): void
    {
        $plainPassword = 'legacy-password';
        $user = User::factory()->create();
        $legacyHash = str_replace('$2y$', '$2a$', password_hash($plainPassword, PASSWORD_BCRYPT));

        DB::table('users')->where('id', $user->id)->update(['password' => $legacyHash]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => $plainPassword,
        ])->assertRedirect('/admin');

        $this->assertAuthenticatedAs($user);

        $updatedHash = DB::table('users')->where('id', $user->id)->value('password');

        $this->assertStringStartsWith('$2y$', $updatedHash);
        $this->assertTrue(password_verify($plainPassword, $updatedHash));
    }
}
