<?php

namespace tests\Feature\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;
use App\Http\Requests\TaskCreateRequest;
use App\Models\Comment;
use phpDocumentor\Reflection\Types\Void_;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private const URI = 'api/task';

    public function test_index_is_successful(): void
    {
        $this->withoutExceptionHandling();
        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $comment = new Comment();
        $comment->setAttribute('title', 'title1');
        $comment->setAttribute('body', 'body1');
        $comment->task()->associate($task);
        $comment->save();

        $response = $this->json('GET', self::URI);
        $response->assertStatus(200);

        $response->assertJson([$task->toArray()]);
        $response->assertJson([$comment->toArray()]);
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
            'status' => 'on progress',
            'comment' => [
                'title' => 'comment title',
                'body' => 'comment body'
            ],
        ]);

        $expected = [
            'name' => 'test task',
            'description' => 'this is a test task',
            'status' => 'on progress',
            'comments' =>[ [
                'title' => 'comment title',
                'body' => 'comment body'
            ]],
        ];

        $response->assertStatus(201)
            ->assertJsonFragment($expected);
        $this->assertDatabaseHas('tasks', [
                    'name' => $expected['name'],
                    'description' => $expected['description'],
                    'status' => $expected['status']]
                );
        $this->assertDatabaseHas('comments', [
            'title' => $expected['title'],
            'body' => $expected['body']
        ]);
    }

    public function testCreateFailsIfRequiredParamAreMissing(): void
    {
        $user = new User();
        $user -> setAttribute('name', 'new_name');
        $user -> setAttribute('email', 'new@gmail.com');
        $user -> setAttribute('password', '123455');
        $user->save();
        Sanctum::actingAs($user);

        $expected = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' =>[
                     'The name field is required.'
              ],
                'description' =>[
                     'The description field is required.'
              ],
                'status' =>[
                     'The status field is required.'
              ],
            ],
        ];

        $response = $this->json('POST', self::URI,[]);
        $response->assertStatus(422)
            ->assertjsonFragment($expected);
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
            'name' => 'task1',
            'description' => 'task-1',
            'status' => 'not on progress'
        ]);
        $expected = [
            'name' => 'task1',
            'description' => 'task-1',
            'status' => 'not on progress'
        ];
        $response->assertStatus(201)
             ->assertJsonFragment($expected);
        $this->assertDatabaseHas('tasks',$expected);
    }

    public function testUpdateFailsIfRequiredParamAreMissing(): void
    {
        $user = new User();
        $user -> setAttribute('name', 'new_name');
        $user -> setAttribute('email', 'new@gmail.com');
        $user -> setAttribute('password', '123455');
        $user->save();
        Sanctum::actingAs($user);

        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $expected = [
            'message' => 'The given data was invalid.',
            'errors' => [
                'name' =>[
                    'The name field is required.'
                ],
                'description' =>[
                    'The description field is required.'
                ],
                'status' =>[
                    'The status field is required.'
                ],
            ],
        ];

        $uri = \sprintf('%s/%s',self::URI,$task->getAttribute('id'));

        $response = $this->json('PUT',$uri,[]);
        $response->assertStatus(422)
            ->assertjsonFragment($expected);
    }

    public function test_destroy_is_succesful(): void
    {
        $this->withoutMiddleware();
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
        $this->assertDatabaseMissing('tasks', [
            'id' => $task->getAttribute('id')
        ]);
    }
}
