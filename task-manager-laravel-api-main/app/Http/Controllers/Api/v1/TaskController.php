<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreTaskRequest;
use App\Http\Requests\v1\UpdateTaskRequest;
use App\Http\Resources\v1\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/tasks",
     *     tags={"Tasks"},
     *     summary="Create task",
     *     operationId="createTask",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", example="title task 1",),
     *             @OA\Property(property="description", example="description task 1"),
     *             @OA\Property(property="date",example="10/10/2022"),
     *         ),
     *     ),
     *     @OA\Response(response="201", description="Created"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     * )
     */
    public function store(StoreTaskRequest $request)
    {
        $data = $request->all();
        $userId = $request->user()->id;
        $task = Task::create([...$data, 'user_id' =>  $userId]);
        return new TaskResource($task);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Get task data",
     *     operationId="getTask",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="403", description="Forbidden"),
     *     @OA\Response(response="404", description="Not Found"),
     * )
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('view', $task);
        return new TaskResource($task);
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Update task",
     *     operationId="updateTask",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", example="title task updated"),
     *             @OA\Property(property="description", example="description task updated"),
     *             @OA\Property(property="date",example="10/10/2022"),
     *         ),
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="400", description="Bad Request"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="403", description="Forbidden"),
     *     @OA\Response(response="404", description="Not Found"),
     * )
     */
    public function update(UpdateTaskRequest $request, $id)
    {
        $data = $request->all();
        $task = Task::findOrFail($id);
        $this->authorize('update', $task);
        $task->update($data);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/tasks/{id}",
     *     tags={"Tasks"},
     *     summary="Delete task",
     *     operationId="deleteTask",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(name="id", in="path", required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="OK"),
     *     @OA\Response(response="401", description="Unauthenticated"),
     *     @OA\Response(response="403", description="Forbidden"),
     *     @OA\Response(response="404", description="Not Found"),
     * )
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $this->authorize('delete', $task);
        $task->delete();
    }
}
