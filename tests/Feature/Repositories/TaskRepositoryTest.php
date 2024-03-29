<?php

namespace Tests\Feature\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Repositories\CommentRepository;
use App\Repositories\TaskRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class TaskRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_task_is_successful(): void
    {
        $user = new User();
        $user->setAttribute('name','test');
        $user->setAttribute('email', 'test@gmail.com');
        $user->setAttribute('password', '2233');
        $user->save();

        $repository = new TaskRepository();

        $result = $repository->createTask([
            'name' => 'task',
            'description' => 'task one',
            'status' => 'ongoing'
        ]);

        $repository2 = new CommentRepository();

        $result2 = $repository2->create([
            'title' => 'new title',
            'body' => 'new body'
        ], $result);

        $expected = [
            'name' => 'task',
            'description' => 'task one',
            'status' => 'ongoing'
        ];

        $this->assertDatabaseHas('tasks', $expected);

        $this->assertDatabaseHas('comments', [
            'title' => 'new title',
            'body' => 'new body'
        ]);
    }

    public function test_index_task_is_successful(): void
    {
        $user = new User();
        $user->setAttribute('name','test');
        $user->setAttribute('email', 'test@gmail.com');
        $user->setAttribute('password', '2233');
        $user->save();

        $repository = new TaskRepository();

        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $result = $repository->getAllTasks();

        $expected = [$task->toArray()];
        self::assertEquals($expected, $result->toArray());
    }

    public function test_update_task_is_successful(): void
    {
        $user = new User();
        $user->setAttribute('name','test');
        $user->setAttribute('email', 'test@gmail.com');
        $user->setAttribute('password', '2233');
        $user->save();

        $repository = new TaskRepository();

        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $result = $repository->update([
            'name' => 'task1',
            'description' => 'task one',
            'status' => 'ongoing'
            ],$task->getAttribute('id'));

        $expected = [
            'name' => 'task1',
            'description' => 'task one',
            'status' => 'ongoing'
        ];

        $this->assertDatabaseHas('tasks', $expected);
    }

    public function test_find_task_is_successful(): void
    {
        $user = new User();
        $user->setAttribute('name','test');
        $user->setAttribute('email', 'test@gmail.com');
        $user->setAttribute('password', '2233');
        $user->save();

        $repository = new TaskRepository();

        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $result = $repository->show($task->getAttribute('id'));

        $expected = $task->toArray();

        self::assertEquals($expected, $result->toArray());
    }

    public function test_delete_task_is_successful(): void
    {
        $user = new User();
        $user->setAttribute('name','test');
        $user->setAttribute('email', 'test@gmail.com');
        $user->setAttribute('password', '2233');
        $user->save();

        $repository = new TaskRepository();

        $task = new Task();
        $task->setAttribute('name', 'task1');
        $task->setAttribute('description', 'task-1');
        $task->setAttribute('status', 'completed');
        $task->save();

        $repository->destroy($task->getAttribute('id'));

        $this->assertDatabaseMissing('tasks', ['id' => $task->getAttribute('id')]);
    }
}
