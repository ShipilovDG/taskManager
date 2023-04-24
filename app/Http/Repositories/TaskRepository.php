<?php declare(strict_types=1);

namespace App\Http\Repositories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class TaskRepository
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Collection
     */
    public function index(Request $request): Collection
    {
        $tasks = Task::all()->where(
            'text',
            'LIKE',
            "%{$request->get('text')}%"
        )->where(
            'status',
            '=',
            $request->get('status')
        )->where(
            'id',
            $request->get('ids')
        );
        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data): Task
    {
        return Task::create($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data): Task
    {
        $task         = Task::findOrFail($data['id']);
        $task->text   = $data['text'];
        $task->status = $data['status'];
        $task->save();

        return $task;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): void
    {
        $task->delete();
    }
}
