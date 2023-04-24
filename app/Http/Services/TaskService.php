<?php declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Repositories\TaskRepository;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TaskService
{
    public function __construct(private TaskRepository $repository)
    {
    }

    public function index(Request $request): Collection
    {
        return $this->repository->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data)
    {
        return $this->repository->store($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data)
    {
        return $this->repository->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->repository->destroy($task);
    }
}
