<?php

use Illuminate\Support\Facades\Route;


/* Páginas públicas */

Route::view('/', 'home')
    ->name('home');

Route::view('/login', 'auth.login')
    ->name('login');

Route::view('/registro', 'auth.register')
    ->name('register');


/* Interfaz estudiantil */

Route::prefix('student')
    ->name('student.')
    ->group(function () {

        Route::view('/', 'student.index')
            ->name('home');

        Route::view('/bookmarks', 'student.bookmarks')
            ->name('bookmarks');

        Route::view('/profile', 'student.profile')
            ->name('profile');


        Route::view('/vacancies/{id}', 'student.vacancy-detail')
            ->name('vacancies.show');
        
        Route::view('/companies/{id}', 'student.company-profile')
            ->name('companies.show');

    });

/* Interfaz empresarial */

Route::prefix('company')
    ->name('company.')
    ->group(function () {

        Route::view('/', 'company.index')
            ->name('home');


        /* Dashboard */

        Route::view('/vacancies', 'company.vacancies')
            ->name('vacancies.index');

        Route::view('/vacancies/create', 'company.vacancy-create')
            ->name('vacancies.create');

        Route::view('/vacancies/{id}/edit', 'company.vacancy-edit')
            ->name('vacancies.edit');

        Route::view('/vacancies/{id}', 'company.vacancy-detail')
            ->name('vacancies.show');

        Route::view('/applications', 'company.applications')
            ->name('applications');

        Route::view('/applications/{id}', 'company.applicant-profile')
            ->name('applications.show');

        Route::view('/ratings', 'company.ratings')
            ->name('ratings');


        /* Membresía */

        Route::view('/membership', 'company.membership')
            ->name('membership');

        Route::view('/membership/change', 'company.change-membership')
            ->name('membership.change');


        /* Perfil */

        Route::view('/profile', 'company.profile')
            ->name('profile');

    });