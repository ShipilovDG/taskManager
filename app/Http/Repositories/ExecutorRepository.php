<?php declare(strict_types=1);

namespace App\Http\Repositories;

use App\Models\Executor;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ExecutorRepository
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Collection
    {
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

        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data): Executor
    {
        $executor = Executor::create($data);

        return $executor;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data): Executor
    {
        $executor          = Executor::findOrFail($data['id']);
        $executor->name    = $data['name'] ?? '';
        $executor->surname = $data['surname'] ?? '';
        $executor->phone   = $data['phone'] ?? '';
        $executor->email   = $data['email'] ?? '';
        $executor->save();

        return $executor;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Executor $executor): void
    {
        $executor->delete();
    }
}
