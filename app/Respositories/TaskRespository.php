<?php
declare(strict_types=1);

namespace App\Respositories;

use App\Models\Task;
use App\Respositories\Interfaces\TaskRespositoryInterface;
use Illuminate\Support\Collection;

class TaskRespository implements TaskRespositoryInterface
{

    public function getAllTasks(): Collection
    {
        return Task::all();
    }

    public function createTask(array $data): Task
    {
        $task = new Task();
        $task->setAttribute('name', $data['name']);
        $task->setAttribute('description', $data['description']);
        $task->setAttribute('status', $data['status']);
        $task->save();

        return $task;
    }

    public function show($id): Task
    {
        return Task::find($id);
    }

    public function update(array $data, $id): Task
    {
        $task = Task::find($id);
        $task->setAttribute('name', $data['name']);
        $task->setAttribute('description', $data['description']);
        $task->setAttribute('status', $data['status']);
        $task->save();

        return $task;
    }

    public function destroy($id): void
    {
        Task::destroy($id);
    }

    public function search($name): Task
    {
        return Task::where('name', 'like', '%'.$name.'%')->get();
    }
}