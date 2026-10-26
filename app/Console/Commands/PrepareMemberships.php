<?php

namespace App\Console\Commands;

use App\Models\Membership;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PrepareMemberships extends Command
{
    protected $signature = 'nextstep:prepare-memberships';

    protected $description = 'Prepara índices y agrega planes iniciales solo cuando no existen';

    public function handle(): int
    {
        try {
            $database = DB::connection('mongodb');
            $database->getCollection('memberships')->createIndex(['code' => 1], ['unique' => true, 'name' => 'memberships_code_unique']);
            $database->getCollection('student_profiles')->createIndex(['user_id' => 1], ['name' => 'student_profiles_user']);
            $database->getCollection('subscriptions')->createIndex(['company_user_id' => 1, 'created_at' => -1], ['name' => 'subscriptions_company_recent']);
            $database->getCollection('subscriptions')->createIndex(['reference' => 1], ['unique' => true, 'sparse' => true, 'name' => 'subscriptions_reference_unique']);
            foreach ([['basic', 'Basic', 150, 8, 1], ['plus', 'Plus', 350, 16, 2], ['premium', 'Premium', 550, null, 3]] as [$code, $name, $price, $limit, $priority]) {
                Membership::firstOrCreate(['code' => $code], ['name' => $name, 'price' => $price, 'vacancy_limit' => $limit, 'priority' => $priority, 'benefits' => [$limit === null ? 'Publicación de vacantes ilimitadas' : "Publicación de hasta {$limit} vacantes", 'Perfil empresarial'], 'active' => true]);
            }
            $this->info('Catálogo e índices preparados. Los planes existentes conservan sus datos.');

            return self::SUCCESS;
        } catch (\Throwable $exception) {
            $this->error('No se pudo preparar el catálogo. Revisa la conexión y códigos de membresía o referencias duplicados.');

            return self::FAILURE;
        }
    }
}
