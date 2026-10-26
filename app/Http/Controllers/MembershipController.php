<?php

namespace App\Http\Controllers;

use App\Http\Requests\MembershipRequest;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use MongoDB\Driver\Exception\BulkWriteException;

class MembershipController extends Controller
{
    public function index(Request $request): mixed
    {
        $filters = $request->validate(['q' => 'nullable|string|max:100', 'active' => 'nullable|in:0,1']);
        $query = Membership::query();
        $isAdmin = $request->user('web')?->role === 'admin' && ! $request->is('api/memberships');
        if (! $isAdmin) {
            $query->where('active', true);
        } elseif (isset($filters['active'])) {
            $query->where('active', $filters['active'] === '1');
        }
        if (! empty($filters['q'])) {
            $query->where('name', 'like', '%'.$filters['q'].'%');
        }
        $memberships = $query->orderBy('priority')->paginate(15)->withQueryString();
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($memberships);
        }
        $summary = [Membership::count(), Membership::where('active', true)->count(), Membership::where('active', false)->count()];

        return view('admin.memberships.index', compact('memberships', 'summary'));
    }

    public function create(): mixed
    {
        return view('admin.memberships.form', ['membership' => new Membership]);
    }

    public function show(string $id): mixed
    {
        return response()->json(Membership::findOrFail($id));
    }

    public function edit(string $id): mixed
    {
        return view('admin.memberships.form', ['membership' => Membership::findOrFail($id)]);
    }

    public function store(MembershipRequest $request): mixed
    {
        try {
            $membership = Membership::create($request->validated());
        } catch (BulkWriteException $exception) {
            if ($exception->getCode() !== 11000) {
                throw $exception;
            }
            throw ValidationException::withMessages(['code' => 'Este código ya está registrado.']);
        }
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($membership, 201);
        }

        return redirect()->route('admin.memberships.index')->with('success', 'Membresía creada. Ya aparece en el catálogo empresarial si está activa.');
    }

    public function update(MembershipRequest $request, string $id): mixed
    {
        $membership = Membership::findOrFail($id);
        $membership->update($request->validated());
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json($membership);
        }

        return redirect()->route('admin.memberships.index')->with('success', 'Membresía actualizada. Las compras anteriores conservan su precio y beneficios.');
    }

    public function destroy(Request $request, string $id): mixed
    {
        $membership = Membership::findOrFail($id);
        $membership->update(['active' => false]);
        if ($request->expectsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Membresía desactivada; se conserva el historial.', 'membership' => $membership]);
        }

        return back()->with('success', 'Membresía desactivada.');
    }
}
