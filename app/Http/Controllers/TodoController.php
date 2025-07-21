<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTodoRequest;

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
        $todo = \App\Models\Todo::create([
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
}
