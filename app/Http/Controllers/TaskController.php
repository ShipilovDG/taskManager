<?php

namespace App\Http\Controllers;

use App\Http\Enums\TaskStatuses;
use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'in:' . implode(',', TaskStatuses::all()),
            'text'   => 'string|max:250',
        ]);

        $tasks = Task::all()->where(
            'text',
            'LIKE',
            "%{$request->get('id')}%"
        )->where('status', '=', $request->get('status'));

        return new JsonResponse(['tasks' => $tasks->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        $success = true;
        $code    = ResponseAlias::HTTP_CREATED;
        $data    = $request->validated();
        try {
            $task = Task::create($data);
        }
        catch (QueryException $exception) {
            $success = false;
            $code    = ResponseAlias::HTTP_BAD_REQUEST;
        }

        return new JsonResponse([
            'success' => $success,
            'object' => $task ?? null,
        ], $code);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request)
    {
        $data         = $request->validated();
        $task         = Task::findOrFail($data['id']);
        $task->text   = $data['text'];
        $task->status = $data['status'];
        $task->save();

        return new JsonResponse($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return new Response(status: 204);
    }
}
