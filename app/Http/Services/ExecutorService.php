<?php declare(strict_types=1);

namespace App\Http\Services;

use App\Http\Repositories\ExecutorRepository;
use App\Models\Executor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ExecutorService
{
    public function __construct(private readonly ExecutorRepository $repository)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Collection
    {
        return $this->repository->index($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data): Executor
    {
        return $this->repository->store($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data): Executor
    {
        return $this->repository->update($data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Executor $executor): void
    {
        $this->repository->destroy($executor);
    }
}
