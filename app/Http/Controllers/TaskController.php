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
     *     operationId="index",
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        //
    }
}
