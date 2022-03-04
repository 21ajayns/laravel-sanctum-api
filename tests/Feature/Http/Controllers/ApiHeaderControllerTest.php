<?php

namespace Tests\Feature\Http\Controllers;

use Tests\TestCase;

class ApiHeaderControllerTest extends TestCase
{
    public function test_for_health_check()
    {
        $this->withoutExceptionHandling();

        $value = ['api-secret' => 'check-api-secret'];
        $response = $this->json('GET','api/health-check',[], $value);

        $response->assertStatus(200);

        $expected = [
            'api-secret' => [
                'check-api-secret'
            ]
        ];

        $response->assertJsonFragment($expected);
    }
}
