<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;
use App\Http\Requests\UpdateTodoRequest;
use \App\Models\Todo;

class TodoController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTodoRequest $request)
    {
        // Validate the request data
        $todo = $request->validated();

        // Create the todo item
        $todo = Todo::create([
            'user_id' => $request->user()->id,
            'title' => $todo['title'],
            'description' => $todo['description'],
        ]);

        // Return a response
        return response()->json([
            'id' => $todo->id,
            'title' => $todo->title,
            'description' => $todo->description,
        ], 201);
    }

    public function update(UpdateTodoRequest $request, Todo $todo)
    {
        // Ensure the authenticated user owns the todo item
        if ($todo->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update the todo item
        $data = $request->validated();
        $todo->title = $data['title'] ?? $todo->title;
        $todo->description = $data['description'] ?? $todo->description;
        $todo->update();

        // Return a response
        return response()->json([
            'id' => $todo->id,
            'title' => $todo->title,
            'description' => $todo->description,
        ]);
    }

    public function delete(Todo $todo)
    {
        // Ensure the authenticated user owns the todo item
        if ($todo->user_id !== request()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Delete the todo item
        $todo->delete();

        // Return a response
        return response()->json(null, 204);
    }

    public function index()
    {
        // Get all todo items for the authenticated user
        $todos = request()->user()->todos()->paginate();

        // Return a response
        return response()->json($todos, 200);
    }
}
