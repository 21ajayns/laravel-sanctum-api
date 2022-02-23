<?php

namespace App\Repositories\Interfaces;

use App\Models\Comment;
use App\Http\Controllers\TaskController;
use App\Models\Task;

interface CommentRepositoryInterface
{
    public function create(array $data, Task $task): Comment;
}
