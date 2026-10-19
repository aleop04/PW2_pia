<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    /* listar vacantes guardadas */
    public function index(Request $request)
    {
        $query = Bookmark::query();

        if ($request->filled('student_user_id')) {
            $studentId = $request->student_user_id;

            User::where('_id', $studentId)
                ->where('role', 'student')
                ->firstOrFail();

            $query->where('student_user_id', $studentId);
        }

        return response()->json($query->get());
    }

    /* mostrar un bookmark específico */
    public function show(Bookmark $bookmark)
    {
        return response()->json($bookmark);
    }

    /* guardar una vacante como favorita */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_user_id' => 'required|string',
            'vacancy_id' => 'required|string',
        ]);

        // Comprobar que el usuario exista y sea estudiante.
        User::where('_id', $validated['student_user_id'])
            ->where('role', 'student')
            ->firstOrFail();

        // Comprobar que la vacante exista y esté publicada.
        Vacancy::where('_id', $validated['vacancy_id'])
            ->where('status', 'published')
            ->firstOrFail();

        $bookmark = Bookmark::firstOrCreate([
            'student_user_id' => $validated['student_user_id'],
            'vacancy_id' => $validated['vacancy_id'],
        ]);

        return response()->json([
            'message' => $bookmark->wasRecentlyCreated
                ? 'Vacante guardada'
                : 'La vacante ya estaba guardada',
            'saved' => true,
            'bookmark' => $bookmark,
        ], $bookmark->wasRecentlyCreated ? 201 : 200);
    }

    /* quitar una vacante de favoritos */
    public function destroy(Bookmark $bookmark)
    {
        $bookmark->delete();

        return response()->json([
            'message' => 'Vacante quitada de guardadas',
            'saved' => false,
        ]);
    }
}