<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('nextstep:prepare-users', function () {
    try {
        $connection = DB::connection('mongodb');
        $connection->getDatabase()->command(['ping' => 1]);
        $connection->getCollection('users')->createIndex(
            ['email' => 1],
            ['unique' => true, 'name' => 'users_email_unique']
        );

        $this->info('Conexión MongoDB correcta. Índice único de correo preparado.');
        $this->line('Base: '.config('database.connections.mongodb.database').' | colección: users | índice: users_email_unique');

        return 0;
    } catch (\Throwable $exception) {
        $this->error('No se pudo preparar users. Revisa MongoDB, DB_URI y DB_DATABASE.');
        $this->line('Si hay correos repetidos en users, corrígelos antes de volver a ejecutar.');

        return 1;
    }
})->purpose('Verifica MongoDB y prepara el índice único de correo de NextStep');

Artisan::command('nextstep:prepare-opportunities', function () {
    try {
        $connection = DB::connection('mongodb');
        $connection->getDatabase()->command(['ping' => 1]);
        $connection->getCollection('vacancies')->createIndex(
            ['company_user_id' => 1, 'status' => 1],
            ['name' => 'vacancies_company_status']
        );
        $connection->getCollection('applications')->createIndex(
            ['student_user_id' => 1, 'vacancy_id' => 1],
            ['unique' => true, 'name' => 'applications_student_vacancy_unique']
        );
        $connection->getCollection('applications')->createIndex(
            ['company_user_id' => 1, 'created_at' => -1],
            ['name' => 'applications_company_recent']
        );
        $connection->getCollection('bookmarks')->createIndex(
            ['student_user_id' => 1, 'vacancy_id' => 1],
            ['unique' => true, 'name' => 'bookmarks_student_vacancy_unique']
        );
        $this->info('Colecciones e índices de vacantes, postulaciones y guardados preparados.');
        return 0;
    } catch (\Throwable $exception) {
        $this->error('No se pudieron preparar los índices. Comprueba MongoDB y revisa postulaciones duplicadas.');
        return 1;
    }
})->purpose('Prepara vacantes y evita postulaciones duplicadas');
