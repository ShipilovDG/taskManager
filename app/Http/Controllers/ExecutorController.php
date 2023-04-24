<?php

namespace App\Http\Controllers;

use App\Http\Enums\TaskStatuses;
use App\Http\Requests\ExecutorsRequest;
use App\Models\Executor;
use App\Models\Task;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ExecutorController extends Controller
{
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

        $tasks = Task::all()->where(
            'name',
            'LIKE',
            "%{$request->get('name')}%"
        )->where(
            'surname',
            'LIKE',
            "%{$request->get('surname')}%"
        )->where(
            'email',
            'LIKE',
            "%{$request->get('email')}%"
        );

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
            $executor = Executor::create($data);
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
        $data              = $request->validated();
        $executor          = Executor::findOrFail($data['id']);
        $executor->name    = $data['name'] ?? '';
        $executor->surname = $data['surname'] ?? '';
        $executor->phone   = $data['phone'] ?? '';
        $executor->email   = $data['email'] ?? '';
        $executor->save();

        return new JsonResponse($executor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Executor $executor)
    {
        $executor->delete();

        return new Response(status: 204);
    }
}
