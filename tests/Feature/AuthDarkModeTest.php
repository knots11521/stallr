<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthDarkModeTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_auth_pages_inherit_the_persisted_dark_mode_state(): void
    {
        $pages = ['/login', '/register', '/forgot-password', '/reset-password/test-token'];

        foreach ($pages as $uri) {
            $response = $this->get($uri);

            $response->assertStatus(200);
            $response->assertSee('localStorage.getItem', true);
            $response->assertSee('theme-toggle', true);
            $response->assertSee('dark:bg-[#1A1A1A]', true);
        }
    }
}
