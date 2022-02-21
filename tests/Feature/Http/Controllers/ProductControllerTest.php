<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private const URI = 'api/products';

    public function test_for_index(): void
    {
        $prod = new product();
        $prod->setAttribute('name', 'prod1');
        $prod->setAttribute('slug', 'prod-1');
        $prod->setAttribute('description', 'this is prod1');
        $prod->setAttribute('price', '99.99');
        $prod->save();

        $prod2 = new product();
        $prod2->setAttribute('name', 'prod2');
        $prod2->setAttribute('slug', 'prod-2');
        $prod2->setAttribute('description', 'this is prod2');
        $prod2->setAttribute('price', '99.90');
        $prod2->save();

        $response = $this->json('GET', self::URI);
        $response->assertStatus(200)
             ->assertjson([$prod->toArray(), $prod2->toArray()]);
    }

    public function test_for_create(): void
    {
        $user = new User();
        $user->setAttribute('name', 'test');
        $user->setAttribute('email', 'test@gmail.com');
        $user->setAttribute('password', '1234');
        $user->save();
        Sanctum::actingAs($user);

        $response = $this->json('POST', self::URI, [
            'name' => 'prod2',
            'slug'=> 'prod-2',
            'description' => 'this is prod2',
            'price' => '99.90'
        ]);

        $expected = [
            'name' => 'prod2',
            'slug'=> 'prod-2',
            'description' => 'this is prod2',
            'price' => '99.90'
        ];

        $response->assertStatus(201)
             ->assertJsonFragment($expected);
        $this->assertDatabaseHas('products', $expected);
    }

    public function testCreateFailsIfParamMissing(): void
    {
        $user = new User();
        $user->setAttribute('name', 'testname');
        $user->setAttribute('email', 'testname@gmail');
        $user->setAttribute('password', 'test123');
        $user->save();
        Sanctum::actingAs($user);
        
        $response = $this->json('POST', self::URI, []);

        $expected = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' =>[
                     'The name field is required.'
              ],
                'slug' =>[
                     'The slug field is required.'
              ],
                'price' =>[
                     'The price field is required.'
              ],
            ],
        ];

        $response->assertStatus(422)
             ->assertJsonFragment($expected);
    }

    public function test_for_find(): void
    {
        $prod = new product();
        $prod->setAttribute('name', 'phone1');
        $prod->setAttribute('slug', 'phone-1');
        $prod->setAttribute('name', 'the phone');
        $prod->setAttribute('price', '50.00');
        $prod->save();
        
        $uri = \sprintf('%s/%s',self::URI, $prod->getAttribute('id'));
        $response = $this->json('GET', $uri);

        $response->assertStatus(200)
             ->assertJson($prod->toArray());
    }

    public function test_for_update(): void
    {
        $user = new User();
        $user->setAttribute('name', 'test');
        $user->setAttribute('email', 'test@gmail.com');
        $user->setAttribute('password', '1234');
        $user->save();
        Sanctum::actingAs($user);

        $product = new product();
        $product->setAttribute('name', 'phone2');
        $product->setAttribute('slug', 'phone-2');
        $product->setAttribute('name', 'the phone');
        $product->setAttribute('price', '50.00');
        $product->save();

        $uri = \sprintf('%s/%s', self::URI, $product->getAttribute('id'));

        $response = $this->json('PUT', $uri, [
            'name' => 'phone2',
            'slug'=> 'phone-2.0',
            'description' => 'the actual phone',
            'price' => '50.01'
        ]);

        $expected = [
            'name' => 'phone2',
            'slug'=> 'phone-2.0',
            'description' => 'the actual phone',
            'price' => '50.01'
        ];
        $response->assertStatus(201)
             ->assertJsonFragment($expected);
        $this->assertDatabaseHas('products', $expected);
    }

    public function testUpdateFailsIfParamMissing(): void
    {
        $user = new User();
        $user->setAttribute('name', 'testname');
        $user->setAttribute('email', 'testname@gmail');
        $user->setAttribute('password', 'test123');
        $user->save();
        Sanctum::actingAs($user);

        $product2 = new product();
        $product2->setAttribute('name', 'phone2');
        $product2->setAttribute('slug', 'phone-2');
        $product2->setAttribute('name', 'the phone');
        $product2->setAttribute('price', '50.00');
        $product2->save();

        $uri = \sprintf('%s/%s', self::URI, $product2->getAttribute('id'));

        $response = $this->json('PUT',$uri,[]);

        $expected = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' =>[
                    'The name field is required.'
                ],
                'slug' =>[
                    'The slug field is required.'
                ],
                'price' =>[
                    'The price field is required.'
                ],
            ],
        ];

        $response->assertStatus(422)
             ->assertJsonFragment($expected);
    }

    public function test_for_destroy(): void
    {
        $user = new User();
        $user->setAttribute('name', 'test');
        $user->setAttribute('email', 'test@gmail.com');
        $user->setAttribute('password', '1234');
        $user->save();
        Sanctum::actingAs($user);

        $prod = new product();
        $prod->setAttribute('name', 'prod1');
        $prod->setAttribute('slug', 'prod-1');
        $prod->setAttribute('description', 'this is prod1');
        $prod->setAttribute('price', '99.99');
        $prod->save();

        $uri = \sprintf('%s/%s', self::URI, $prod->getAttribute('id'));
        $response = $this->json('DELETE',$uri);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('products', [
            'id' => $prod->getAttribute('id')
        ]);

    }
}
