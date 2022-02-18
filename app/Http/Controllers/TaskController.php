<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Models\Task;
use App\Respositories\Interfaces\TaskRespositoryInterface;
use App\Respositories\TaskRespository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    private TaskRespositoryInterface $taskRepository;
    public function __construct(TaskRespositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }
    /**
     * Display a listing of the resource
     */
    public function index(): Response
    {
        $tasks = $this->taskRepository->getAllTasks();
        return new Response($tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskCreateRequest $request): Response
    {
        $tasks = $this->taskRepository->createTask($request->all());
        return new Response($tasks->toArray(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = $this->taskRepository->show($id);
        return new Response($tasks);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskCreateRequest $request, $id): Response
    {
        $tasks = $this->taskRepository->update($request->all(), $id);
        return new Response($tasks->toArray(), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tasks = $this->taskRepository->destroy($id);
    }
    
    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name): Response
    {
        $tasks = $this->taskrepository->search($name);
        return new Response($tasks);
    }
}
