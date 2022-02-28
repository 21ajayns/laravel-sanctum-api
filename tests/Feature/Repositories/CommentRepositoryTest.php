<?php

namespace Tests\Feature\Repositories;

use App\Models\Task;
use App\Models\User;
use App\Repositories\CommentRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentRepositoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_create_comment_is_successful(): void
    {
        $user = new User();
        $user -> setAttribute('name', 'test_name');
        $user -> setAttribute('email', 'test@gmail.com');
        $user -> setAttribute('password', '12345');
        $user->save();

        $repository = new CommentRepository;

        $task = new Task();

        $result = $repository->create([
            'title' => 'New title',
            'body' => 'New body'
        ], $task);

        $this->assertDatabaseHas('comments', [
            'title' => 'New title',
            'body' => 'New body'
        ]);
    }
}
