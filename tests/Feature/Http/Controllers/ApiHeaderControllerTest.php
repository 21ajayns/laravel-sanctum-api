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

    public function getDifferentInputCombinations(): iterable
    {
        yield 'header without value' => [
            'input' => [
                'api_secret' => null
            ],
            'expected' => [
                'message' => 'Missing api header credentials'
            ]
        ];

        yield 'header with wrong key' => [
            'input' => [
                'api_secret' => 'wrong key'
            ],
            'expected' => [
                'message' => 'Missing api header credentials'
            ]
        ];

        yield 'no header' => [
            'input' => [],
            'expected' => [
                'message' => 'Missing api header credentials'
            ]
        ];
    }

    /**
     * @dataProvider getDifferentInputCombinations
     */
    public function test_header_and_value(array $input, array $expected): void
    {
        $response = $this->json('GET','api/health-check',[], $input);

        $response->assertStatus(422)
             ->assertJson($expected);
    } 
}
