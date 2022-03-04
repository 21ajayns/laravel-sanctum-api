<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class ApiHeaderControllerTest extends TestCase
{
    public function test_for_health_check()
    {
        $this->withoutExceptionHandling();

        $value = ['api_secret' => 'check_api_secret'];
        $response = $this->json('GET','api/health-check',[], $value);

        $response->assertStatus(200);

        $response->assertJsonFragment(['api_secret' => ['check_api_secret']]);
        //$response->assertJson("access granted");
    }
}
