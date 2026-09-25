<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class TaskController extends Controller
{
    public function index(): View
    {
        $tasks = Schema::hasTable('tasks') ? Task::orderBy('created_at', 'desc')->get() : collect();

        return view('tasks.index', compact('tasks'));
    }

    public function freeTime(): View
    {
        $tasks = Schema::hasTable('tasks') ? Task::orderBy('created_at', 'desc')->get() : collect();

        return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request): RedirectResponse
    {
        Task::create($this->validatedTaskData($request));

        return redirect()->route('tasks.index');
    }

    public function edit(Task $task): View
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $task->update($this->validatedTaskData($request));

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();

        return redirect()->route('tasks.index');
    }

    /**
     * @return array{task_name: string, description: ?string, status: string, due_date: ?string}
     */
    private function validatedTaskData(Request $request): array
    {
        return $request->validate([
            'task_name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'string', 'in:pending,completed'],
            'due_date' => ['nullable', 'date'],
        ]);
    }
}