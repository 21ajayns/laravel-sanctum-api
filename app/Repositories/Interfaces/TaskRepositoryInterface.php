<?php

namespace App\Repositories\Interfaces;

use App\Models\Task;
use illuminate\support\Collection;

interface TaskRepositoryInterface
{
    public function getAllTasks(): Collection;
    
    public function createTask(array $data): Task;

    public function show($id): Task;

    public function update(array $data, $id): Task;

    public function destroy($id): void;

    public function search($name): Task;
}
?>