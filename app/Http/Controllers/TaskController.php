<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Models\Task;
use App\Respositories\Interfaces\TaskRespositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(TaskRespositoryInterface $taskRespository)
    {
        $this->taskrepository = $taskRespository;
    }
    /**
     * Display a listing of the resource
     */
    public function index(): Response
    {
        $tasks = $this->taskRespository->getAllTasks();
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
        $tasks = $this->taskRespository->createTask($request->all());
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
        $tasks = $this->taskRespository->show($id);
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
        $tasks = $this->taskRespository->update($request->all(), $id);
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
        $tasks = $this->taskRespository->destroy($id);
    }
    
    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name): Response
    {
        $tasks = $this->taskrespository->search($name);
        return new Response($tasks);
    }
}
