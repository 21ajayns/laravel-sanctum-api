<?php
declare(strict_types=1);

namespace App\Repositories;

use App\Models\Comment;
use App\Models\Task;
use App\Repositories\Interfaces\CommentRepositoryInterface;

class CommentRepository implements CommentRepositoryInterface
{
    public function create(array $data, Task $task): Comment
    {
        $comment = new Comment();
        $comment->setAttribute('title', $data['title']);
        $comment->setAttribute('body', $data['body']);
        $comment->task()->associate($task);
        $comment->save();

        return $comment;
    }
}
