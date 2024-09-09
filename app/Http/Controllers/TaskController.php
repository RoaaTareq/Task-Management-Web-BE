<?php
namespace App\Http\Controllers;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Events\TaskUpdated;
class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
       
        $tasks = Task::all();
        
        return response()->json($tasks);
    }
    
    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'required|date',
        'priority' => 'required|in:low,medium,high',
        'categories' => 'array|nullable',
        'assigned_users' => 'array|nullable', // Validate array of user IDs
        'assigned_users.*' => 'exists:users,id', // Validate each user ID
    ]);

    // Get the currently authenticated user ID
    $userId = auth()->id();

    if (!$userId) {
        return response()->json(['error' => 'User not authenticated'], 401);
    }

    // Create the task and associate it with the authenticated user
    $task = Task::create([
        'title' => $request->input('title'),
        'description' => $request->input('description'),
        'due_date' => $request->input('due_date'),
        'priority' => $request->input('priority'),
        'user_id' => $userId,  // Set the user_id here
    ]);

    if ($request->has('categories')) {
        $task->categories()->sync($request->input('categories'));
    }

    if ($request->has('assigned_users')) {
        $task->assignedUsers()->sync($request->input('assigned_users')); // Sync assigned users
    }

    return response()->json($task, 201);
}


public function getTaskCategories($taskId)
{
    $task = Task::findOrFail($taskId);
    $categories = $task->categories;

    return response()->json($categories, 200);
}

// Get all users assigned to a task
public function getUsersForTask($taskId)
{
    $task = Task::findOrFail($taskId);
    $users = $task->users;

    return response()->json($users, 200);
}


    




    public function show(Task $task)
    {
        if ($task->user_id != Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return response()->json($task);
    }

    public function update(Request $request, Task $task)
{
    if ($task->user_id != Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $task->update($request->only('title', 'description', 'due_date', 'priority', 'is_completed'));

    if ($request->has('categories')) {
        $task->categories()->sync($request->categories);
    }

    broadcast(new TaskUpdated($task));

    return response()->json($task);
}

public function destroy(Task $task)
{
    if ($task->user_id != Auth::id()) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    $task->delete();

    return response()->json(['message' => 'Task deleted']);
}
}

?>