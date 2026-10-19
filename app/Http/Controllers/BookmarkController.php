<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Vacancy;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function store(Request $request, string $id)
    {
        Vacancy::where('_id', $id)->where('status', 'published')->firstOrFail();
        $studentId = (string) $request->user()->getKey();
        try {
            Bookmark::firstOrCreate(['student_user_id' => $studentId, 'vacancy_id' => $id]);
        } catch (\Throwable $error) {
            if (!str_contains($error->getMessage(), 'E11000')) throw $error;
        }
        return $request->expectsJson() ? response()->json(['saved' => true]) : back()->with('success', 'Vacante guardada.');
    }

    public function destroy(Request $request, string $id)
    {
        Bookmark::where('student_user_id', (string) $request->user()->getKey())
            ->where('vacancy_id', $id)->delete();
        return $request->expectsJson() ? response()->json(['saved' => false]) : back()->with('success', 'Vacante quitada de guardadas.');
    }
}
