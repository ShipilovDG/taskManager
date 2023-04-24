<?php

namespace App\Http\Controllers;

use App\Http\Enums\TaskStatuses;
use App\Http\Requests\ExecutorsRequest;
use App\Http\Services\ExecutorService;
use App\Models\Executor;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ExecutorController extends Controller
{
    public function __construct(private readonly ExecutorService $service)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        $request->validate([
            'name'    => 'string|max:250',
            'surName' => 'string|max:250',
            'email'   => 'email',
        ]);

        $tasks = $this->service->index($request);

        return new JsonResponse(['tasks' => $tasks->toArray()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExecutorsRequest $request)
    {
        $success = true;
        $code    = ResponseAlias::HTTP_CREATED;
        $data    = $request->validated();
        try {
            $executor = $this->service->store($data);
        }
        catch (QueryException $exception) {
            $success = false;
            $code    = ResponseAlias::HTTP_BAD_REQUEST;
        }

        return new JsonResponse(
            [
                'success' => $success,
                'object'  => $executor ?? null,
            ], $code);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ExecutorsRequest $request)
    {
        $data     = $request->validated();
        $executor = $this->service->update($data);

        return new JsonResponse($executor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Executor $executor)
    {
        $this->service->destroy($executor);

        return new Response(status: 204);
    }

    public function attachTasks(Request $request)
    {
        $request->validate([
            'executorId' => 'int',
            'taskIds'    => 'array',
            'taskIds.*'  => 'int',
        ]);
        $executor = Executor::findOrFail($request->get('executorId'));
        foreach ($request->get('tasksIds') as $item) {
            $executor->tasks()->attach($item);
        }

        return new JsonResponse(['success' => true]);
    }
}
