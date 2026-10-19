<?php

namespace App\Http\Controllers;

use App\Models\CompanyReview;
use Illuminate\Http\Request;

class CompanyReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_user_id' => 'required|string',
            'student_user_id' => 'required|string',
            'job_title' => 'required|string',
            'job_location' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'review_title' => 'required|string',
            'review_description' => 'required|string',
            'employment_start_date' => 'required|date',
            'employment_end_date' => 'required|date',
        ]);

        $review = CompanyReview::create($validated);
        return response()->json($review, 201);
    }

    public function index()
    {
        return response()->json(CompanyReview::all(), 200);
    }

    public function update(Request $request, $id)
    {
        $review = CompanyReview::findOrFail($id);
        $review->update($request->all());
        return response()->json($review, 200);
    }

    public function destroy($id)
    {
        $review = CompanyReview::findOrFail($id);
        $review->delete();
        return response()->json(['message' => 'Valoración eliminada'], 200);
    }
}