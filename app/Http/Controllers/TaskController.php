<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskCreateRequest;
use App\Http\Requests\TaskUpdateRequest;
use App\Models\Task;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    private CommentRepositoryInterface $commentRepository;
    private TaskRepositoryInterface $taskRepository;

    public function __construct(CommentRepositoryInterface $commentRepository, TaskRepositoryInterface $taskRepository)
    {
        $this->commentRepository = $commentRepository;
        $this->taskRepository = $taskRepository;
    }

    /**
     * Display a listing of the resource
     */
    public function index(): Response
    {
        $task = $this->taskRepository->getAllTasks();
        return new Response($task);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskCreateRequest $request): Response
    {
        $task = $this->taskRepository->createTask($request->all());
        $comment = $request->get('comment');
        
        $comment = $this->commentRepository->create($comment, $task);
        $comment->task()->associate($task);

        return new Response($task->toArray(), 201);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = $this->taskRepository->show($id);
        return new Response($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskUpdateRequest $request, $id): Response
    {
        $task = $this->taskRepository->update($request->all(), $id);
        return new Response($task->toArray(), 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = $this->taskRepository->destroy($id);
    }

    /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name): Response
    {
        $task = $this->taskRepository->search($name);
        return new Response($task);
    }
}
