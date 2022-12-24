<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomeControllerTest extends TestCase
{
  /**
   * A basic feature test example.
   *
   * @return void
   */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200)
            ->assertViewIs('welcome')
            ->assertSee('ログイン')
            ->assertSee('新規登録');
    }

    public function test_fails_users_home_when_not_login()
    {
        $response = $this->get('/tasks');

        $response->assertStatus(302);
    }
}
