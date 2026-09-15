<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    // Get all positions with their linked role
    public function index()
    {
        $positions = Position::with('role')->get();
        return response()->json($positions);
    }

    // Create a new position
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'role_id' => 'required|exists:roles,id',
        ]);

        $position = Position::create($request->only('title', 'role_id'));

        return response()->json($position->load('role'), 201);
    }

    // Show one position
    public function show(Position $position)
    {
        return response()->json($position->load('role'));
    }

    // Update position
    public function update(Request $request, Position $position)
    {
        $request->validate([
            'title' => 'sometimes|string|max:255',
            'role_id' => 'sometimes|exists:roles,id',
        ]);

        $position->update($request->only('title', 'role_id'));

        return response()->json($position->load('role'));
    }

    // Delete position
    public function destroy(Position $position)
    {
        $position->delete();
        return response()->json(['message' => 'Position deleted successfully']);
    }
}