<?php

namespace App\Http\Controllers;

use App\Http\Enums\TaskStatuses;
use App\Http\Requests\TaskRequest;
use App\Http\Services\TaskService;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class TaskController extends Controller
{
    public function __construct(private readonly TaskService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'in:' . implode(',', TaskStatuses::all()),
            'text'   => 'string|max:250',
            'ids'    => 'array',
            'ids.*'  => 'integer',
        ]);

        $tasks = $this->service->index($request);

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
            $task = $this->service->store($data);
        }
        catch (QueryException $exception) {
            $success = false;
            $code    = ResponseAlias::HTTP_BAD_REQUEST;
        }

        return new JsonResponse([
            'success' => $success,
            'object'  => $task ?? null,
        ], $code);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request)
    {
        $data = $request->validated();
        $task = $this->service->update($data);

        return new JsonResponse($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->service->destroy($task);

        return new Response(status: 204);
    }
}
