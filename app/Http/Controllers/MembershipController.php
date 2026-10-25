<?php

namespace App\Http\Controllers;

use App\Models\Membership;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
            'name' => 'required|string',
            'price' => 'required|numeric|min:0', 
            'vacancy_limit' => 'nullable|integer|min:0', 
            'priority' => 'required|integer|min:1',
            'benefits' => 'required|array',
            'active' => 'required|boolean'
        ]);

        $membership = Membership::create($validated);
        return response()->json($membership, 201);
    }

    public function index()
    {
        return response()->json(Membership::all(), 200);
    }

    public function update(Request $request, $id)
    {
        $membership = Membership::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'price' => 'sometimes|required|numeric|min:0',
            'vacancy_limit' => 'sometimes|nullable|integer|min:0',
            'priority' => 'sometimes|required|integer|min:1',
            'benefits' => 'sometimes|required|array',
            'active' => 'sometimes|required|boolean'
        ]);

        $membership->update($validated);
        return response()->json($membership, 200);
    }

    public function destroy($id)
    {
        $membership = Membership::findOrFail($id);
        $membership->delete();
        return response()->json(['message' => 'Plan eliminado'], 200);
    }
}