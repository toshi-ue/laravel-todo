<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;
use App\User;

class HomeControllerTest extends TestCase
{
    use RefreshDatabase;

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

    public function test_fail_redirect_tasks_when_user_not_login()
    {
        $response = $this->get('/tasks');

        $response->assertStatus(302);
    }
}
