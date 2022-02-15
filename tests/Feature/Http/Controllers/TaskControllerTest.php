<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use phpDocumentor\Reflection\Types\This;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private const URI = 'api/task';

    public function test_Index_is_succesful(): void
    {
        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $task2 = new Task();
        $task2->setAttribute('name', 'task2');
        $task2->setAttribute('description', 'task-2');
        $task2->setAttribute('status', 'not completed');
        $task2->save();

        $response = $this->json('GET', self::URI);
        $response->assertStatus(200)
           ->assertJson([$task->toArray(), $task2->toArray()]);
    }

    public function test_create_is_successful(): void
    {
        $user = new User();
        $user -> setAttribute('name', 'test_name');
        $user -> setAttribute('email', 'test@gmail.com');
        $user -> setAttribute('password', '12345');
        $user->save();
        Sanctum::actingAs($user);

        $response = $this->json('POST', self::URI, [
            'name' => 'test task',
            'description' => 'this is a test task',
            'status' => 'on progress'
        ]);
        $expected = [
            'name' => 'test task',
            'description' => 'this is a test task',
            'status' => 'on progress'
        ];
        $response->assertStatus(201)
        ->assertJsonFragment($expected);
        $this->assertDatabaseHas('tasks',$expected);

    }

    public function test_find_is_succesful(): void
    {
        $this->withoutExceptionHandling();
        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $uri = \sprintf('%s/%s',self::URI,$task->getAttribute('id'));

        $response = $this->json('GET', $uri);
        $response->assertStatus(200)
          ->assertjson($task->toArray());
    }

    public function test_update_is_successful(): void
    {
        $this->withExceptionHandling();
        $user = new User();
        $user -> setAttribute('name', 'test_name1');
        $user -> setAttribute('email', 'test1@gmail.com');
        $user -> setAttribute('password', '123456');
        $user->save();
        Sanctum::actingAs($user);

        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $uri = \sprintf('%s/%s',self::URI,$task->getAttribute('id'));
        $response = $this->json('PUT', $uri, [
            'status' => 'not on progress'
        ]);
        $expected = [
            'name' => 'task1',
            'description' => 'task-1',
            'status' => 'not on progress'
        ];
        $response->assertStatus(200)
        ->assertJsonFragment($expected);
        $this->assertDatabaseHas('tasks',$expected);
    }

    public function test_destroy_is_succesful(): void
    {
        $this->withExceptionHandling();
        $user = new User();
        $user -> setAttribute('name', 'test_name2');
        $user -> setAttribute('email', 'test2@gmail.com');
        $user -> setAttribute('password', '1234');
        $user->save();
        Sanctum::actingAs($user);

        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $task2 = new Task();
        $task2->setAttribute('name', 'task2');
        $task2->setAttribute('description', 'task-2');
        $task2->setAttribute('status', 'not completed');
        $task2->save();

        $uri = \sprintf('%s/%s',self::URI,$task->getAttribute('id'));

        $response = $this->json('DELETE', $uri);
        $response->assertStatus(200);
    }

    // public function test_login_is_succesful(): void
    // {
    //     $this->withExceptionHandling();

    //     $response = $this->json('POST', 'api/register', [
    //         'name' => 'test_name3',
    //         'email' => 'test3@gmail.com',
    //         'password' => '12345',
    //         'password_confirmation' => '12345'
    //     ]);
    //     $response->assertStatus(201);

    //     $log = $this->json('POST', 'api/login', [
    //         'name' => 'test_name3',
    //         'email' => 'test3@gmail.com',
    //         'password' => '12345'
    //     ]);
    //     $log->assertStatus(201);
    // }
}
