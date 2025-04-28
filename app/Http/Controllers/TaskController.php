<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    /**
     * @OA\Get(
     *     path="/api/tasks",
     *     summary="Get all tasks",
     *     description="Returns a list of tasks",
     *     operationId="getTasks",
     *     tags={"Tasks"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful response"
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No tasks found"
     *     )
     * )
    */
    public function index(Request $request)
    {
        $filters = $request->only(['project_id']); // for safety we only get project id from request

        $taskList = $this->taskService->getAllTasks($filters);
        return response()->json($taskList, empty($taskList) ? Response::HTTP_NO_CONTENT : Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:1000',
            'project_id'    => 'required|exists:projects,id',
            'priority'      => 'required|integer|min:1',
        ]);

        $task = $this->taskService->createTask($validated);
        return response()->json($task, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $updatedTask = $this->taskService->updateTask($task, $request->all());
        return response()->json($updatedTask, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $deleteResult = $this->taskService->deleteTask($task);
        return response()->json($deleteResult, Response::HTTP_NO_CONTENT);
    }
}
