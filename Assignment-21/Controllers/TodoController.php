<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
public function index()
{
    $user = auth()->user();
    $todos = $user->todos;
    return response()->json($todos);
}

public function store(Request $request)
{
    $user = auth()->user();

    $this->validate($request, [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $todo = new Todo([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    $user->todos()->save($todo);

    return response()->json(['message' => 'Todo created successfully'], 201);
}

public function update(Request $request, $id)
{
    $user = auth()->user();
    $todo = Todo::where('user_id', $user->id)->findOrFail($id);

    $this->validate($request, [
        'title' => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    $todo->update([
        'title' => $request->title,
        'description' => $request->description,
    ]);

    return response()->json(['message' => 'Todo updated successfully']);
}

public function destroy($id)
{
    $user = auth()->user();
    $todo = Todo::where('user_id', $user->id)->findOrFail($id);
    $todo->delete();

    return response()->json(['message' => 'Todo deleted successfully']);
}
}
