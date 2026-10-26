<?php

use App\Http\Controllers\AdminController; // crea rutas
use App\Http\Controllers\Api\AuthController; // controlador d login registro y logout
use App\Http\Controllers\ApplicationController; // controlador perfiles
use App\Http\Controllers\BookmarkController; // controlador vacantes d empresas
use App\Http\Controllers\CompanyMembershipController; // controlador vacantes d estudiante
use App\Http\Controllers\CompanyVacancyController; // controlador postulaciones
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentVacancyController;
use Illuminate\Support\Facades\Route; // controlador vacantes guardadas

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

        // vista temporal hasta integrar guardados
        Route::view('/bookmarks', 'student.bookmarks')
            ->name('bookmarks');
        Route::get('/profile', [ProfileController::class, 'student'])
            ->name('profile');
        Route::post('/profile', [ProfileController::class, 'updateStudent'])
            ->name('profile.update');
        Route::get('/profile/cv', [ProfileController::class, 'cv'])
            ->name('profile.cv');
        Route::get('/profile/kardex', [ProfileController::class, 'kardex'])
            ->name('profile.kardex');

        Route::get('/vacancies/{id}', [StudentVacancyController::class, 'show'])
            ->name('vacancies.show');
        Route::post('/vacancies/{id}/applications', [ApplicationController::class, 'store'])->name('applications.store');
        Route::post('/vacancies/{id}/bookmark', [BookmarkController::class, 'store'])
            ->name('bookmarks.store');
        Route::delete('/vacancies/{id}/bookmark', [BookmarkController::class, 'destroy'])
            ->name('bookmarks.destroy');

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

        Route::get('/applications', [ApplicationController::class, 'companyIndex'])
            ->name('applications');

        Route::get('/applications/{id}', [ApplicationController::class, 'show'])
            ->name('applications.show');
        Route::get('/applications/{id}/cv', [ApplicationController::class, 'cv'])->name('applications.cv');
        Route::patch('/applications/{id}/status', [ApplicationController::class, 'status'])->name('applications.status');

        Route::view('/ratings', 'company.ratings')
            ->name('ratings');

        /* Membresía */

        Route::get('/membership', [CompanyMembershipController::class, 'index'])
            ->name('membership');

        Route::get('/membership/change', [CompanyMembershipController::class, 'catalog'])
            ->name('membership.change');

        Route::get('/profile', [ProfileController::class, 'company'])
            ->name('profile');
        Route::post('/profile', [ProfileController::class, 'updateCompany'])
            ->name('profile.update');

    });

/* Administración: la misma sesión web, con rol leído desde MongoDB. */
Route::prefix('admin')->name('admin.')->middleware(['auth:web', 'role:admin'])->group(function () {
    Route::redirect('/', '/admin/students')->name('home');
    Route::get('/students', [AdminController::class, 'students'])->name('students.index');
    Route::get('/students/{id}', [AdminController::class, 'student'])->where('id', '[a-f0-9]{24}')->name('students.show');
    Route::get('/students/{id}/{document}', [AdminController::class, 'document'])->where('id', '[a-f0-9]{24}')->where('document', 'cv|kardex')->name('students.document');
    Route::get('/companies', [AdminController::class, 'companies'])->name('companies.index');
    Route::get('/companies/{id}', [AdminController::class, 'company'])->where('id', '[a-f0-9]{24}')->name('companies.show');
    Route::get('/memberships', [MembershipController::class, 'index'])->name('memberships.index');
    Route::get('/memberships/create', [MembershipController::class, 'create'])->name('memberships.create');
    Route::post('/memberships', [MembershipController::class, 'store'])->name('memberships.store');
    Route::get('/memberships/{id}/edit', [MembershipController::class, 'edit'])->where('id', '[a-f0-9]{24}')->name('memberships.edit');
    Route::put('/memberships/{id}', [MembershipController::class, 'update'])->where('id', '[a-f0-9]{24}')->name('memberships.update');
    Route::delete('/memberships/{id}', [MembershipController::class, 'destroy'])->where('id', '[a-f0-9]{24}')->name('memberships.destroy');
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments.index');
    Route::get('/payments/{id}', [AdminController::class, 'payment'])->where('id', '[a-f0-9]{24}')->name('payments.show');
});
Route::middleware(['auth:web', 'role:company'])->group(function () {
    Route::post('/company/membership/orders', [CompanyMembershipController::class, 'store'])->name('company.membership.orders.store');
    Route::patch('/company/membership/orders/{id}/cancel', [CompanyMembershipController::class, 'cancel'])->where('id', '[a-f0-9]{24}')->name('company.membership.orders.cancel');
});
