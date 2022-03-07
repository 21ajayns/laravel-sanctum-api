<?php

namespace Tests\Feature\Http\Controllers;

use App\Exceptions\ApiSecretMissingException;
use phpDocumentor\Reflection\Types\Null_;
use Tests\TestCase;

class ApiHeaderControllerTest extends TestCase
{
    public function test_for_health_check()
    {
        $value = ['api_secret' => 'check-api-secret'];
        $response = $this->json('GET','api/health-check',[], $value);

        $response->assertStatus(200);

        $expected = [
            'api-secret' => [
                'check-api-secret'
            ]
        ];

        $response->assertJsonFragment($expected);
    }

    public function test_header_without_value()
    {
        $this->expectException(ApiSecretMissingException::class);
        $this->expectExceptionMessage('Missing api header credentials');

        $value = ['api_secret' => null];
        $response = $this->json('GET','api/health-check',[], $value);

        $response->assertStatus(422);
    }

    public function test_header_with_wrong_key()
    {
        $this->expectException(ApiSecretMissingException::class);
        $this->expectExceptionMessage('Missing api header credentials');

        $value = ['api_header' => 'wrong-key'];
        $response = $this->json('GET', 'api/health-check',[], $value);

        $response->assertStatus(422);
    }

    public function test_without_header()
    {
        $this->expectException(ApiSecretMissingException::class);
        $this->expectExceptionMessage('Missing api header credentials');

        $response = $this->json('GET', 'api/health-check',[], []);

        $response->assertStatus(422);
    }
    
}
