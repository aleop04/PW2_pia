<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CompanyVacancyController;
use App\Http\Controllers\StudentVacancyController;
use App\Http\Controllers\ApplicationController;


/* Páginas públicas */

Route::view('/', 'home')
    ->name('home');

Route::middleware('guest:web')->group(function () {
    Route::view('/login', 'auth.login')->name('login');
    Route::view('/registro', 'auth.register')->name('register');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:6,1,login')->name('login.store');
    Route::post('/registro/estudiante', [AuthController::class, 'registerStudent'])
        ->middleware('throttle:10,1,register-student')->name('register.student');
    Route::post('/registro/empresa', [AuthController::class, 'registerCompany'])
        ->middleware('throttle:10,1,register-company')->name('register.company');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:web')->name('logout');


/* Interfaz estudiantil */

Route::prefix('student')
    ->name('student.')
    ->middleware(['auth:web', 'role:student'])
    ->group(function () {

        Route::get('/', [StudentVacancyController::class, 'index'])
            ->name('home');

        // Vista temporal hasta integrar el módulo persistente de guardados.
        Route::view('/bookmarks', 'student.bookmarks')
            ->name('bookmarks');

        Route::get('/applications', [ApplicationController::class, 'studentIndex'])
            ->name('applications.index');

        // Vista temporal hasta integrar los perfiles persistentes.
        Route::view('/profile', 'student.profile')
            ->name('profile');


        Route::get('/vacancies/{id}', [StudentVacancyController::class, 'show'])
            ->name('vacancies.show');
        Route::post('/vacancies/{id}/applications', [ApplicationController::class, 'store'])->name('applications.store');
        
        Route::get('/companies/{id}', [StudentVacancyController::class, 'company'])
            ->name('companies.show');

    });

/* Interfaz empresarial */

Route::prefix('company')
    ->name('company.')
    ->middleware(['auth:web', 'role:company'])
    ->group(function () {

        Route::get('/', [CompanyVacancyController::class, 'dashboard'])
            ->name('home');


        /* Dashboard */

        Route::get('/vacancies', [CompanyVacancyController::class, 'index'])
            ->name('vacancies.index');

        Route::view('/vacancies/create', 'company.vacancy-create')
            ->name('vacancies.create');
        Route::post('/vacancies', [CompanyVacancyController::class, 'store'])->name('vacancies.store');

        Route::get('/vacancies/{id}/edit', [CompanyVacancyController::class, 'edit'])
            ->name('vacancies.edit');
        Route::put('/vacancies/{id}', [CompanyVacancyController::class, 'update'])->name('vacancies.update');
        Route::delete('/vacancies/{id}', [CompanyVacancyController::class, 'destroy'])->name('vacancies.destroy');

        Route::get('/vacancies/{id}', [CompanyVacancyController::class, 'show'])
            ->name('vacancies.show');

        Route::get('/applications', [ApplicationController::class, 'index'])
            ->name('applications');

        Route::get('/applications/{id}', [ApplicationController::class, 'show'])
            ->name('applications.show');
        Route::get('/applications/{id}/cv', [ApplicationController::class, 'cv'])->name('applications.cv');
        Route::patch('/applications/{id}/status', [ApplicationController::class, 'status'])->name('applications.status');

        Route::view('/ratings', 'company.ratings')
            ->name('ratings');


        /* Membresía */

        Route::view('/membership', 'company.membership')
            ->name('membership');

        Route::view('/membership/change', 'company.change-membership')
            ->name('membership.change');

        // Vista temporal hasta integrar los perfiles persistentes.
        Route::view('/profile', 'company.profile')
            ->name('profile');


    });
