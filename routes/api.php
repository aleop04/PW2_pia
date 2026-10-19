<?php

Route::apiResource('memberships', App\Http\Controllers\MembershipController::class);
Route::apiResource('users', App\Http\Controllers\UserController::class);
Route::apiResource('vacancies', App\Http\Controllers\VacancyController::class);
Route::apiResource('applications', App\Http\Controllers\ApplicationController::class);
Route::apiResource('subscriptions', App\Http\Controllers\SubscriptionController::class);
Route::apiResource('company_reviews', App\Http\Controllers\CompanyReviewController::class);