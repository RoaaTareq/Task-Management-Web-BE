<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Priority;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::with(['category', 'priority', 'users'])->get();
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $categories = Category::all();
        $priorities = Priority::all();
        $users = \App\Models\User::all(); // Assuming you have a User model
        return view('tasks.create', compact('categories', 'priorities', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'complete' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'user_ids' => 'array|exists:users,id'
        ]);

        $task = Task::create([
            'name' => $validated['name'],
            'date' => $validated['date'],
            'complete' => $validated['complete'] ?? false,
            'category_id' => $validated['category_id'],
            'priority_id' => $validated['priority_id'],
        ]);

        if (isset($validated['user_ids'])) {
            $task->users()->sync($validated['user_ids']);
        }

        return redirect()->route('tasks.index');
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $categories = Category::all();
        $priorities = Priority::all();
        $users = \App\Models\User::all(); // Assuming you have a User model
        return view('tasks.edit', compact('task', 'categories', 'priorities', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'complete' => 'boolean',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'user_ids' => 'array|exists:users,id'
        ]);

        $task->update([
            'name' => $validated['name'],
            'date' => $validated['date'],
            'complete' => $validated['complete'] ?? false,
            'category_id' => $validated['category_id'],
            'priority_id' => $validated['priority_id'],
        ]);

        if (isset($validated['user_ids'])) {
            $task->users()->sync($validated['user_ids']);
        }

        return redirect()->route('tasks.index');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks.index');
    }
}
