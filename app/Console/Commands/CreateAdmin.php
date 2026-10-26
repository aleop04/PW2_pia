<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'nextstep:create-admin {email?}';

    protected $description = 'Crea una cuenta administradora sin exponer la contraseña en comandos ni archivos';

    public function handle(): int
    {
        $email = strtolower(trim($this->argument('email') ?? $this->ask('Correo del administrador')));
        $name = $this->ask('Nombre del administrador');
        $password = $this->secret('Contraseña (8 a 72 caracteres)');
        $confirmation = $this->secret('Repite la contraseña');
        $validator = Validator::make(compact('email', 'name', 'password') + ['password_confirmation' => $confirmation], [
            'email' => 'required|email|max:255|unique:users,email',
            'name' => 'required|string|max:100',
            'password' => 'required|string|min:8|max:72|confirmed',
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }
        User::create(['email' => $email, 'first_name' => $name, 'password' => $password, 'role' => 'admin']);
        $this->info('Administrador creado. Entra con este correo en /login.');

        return self::SUCCESS;
    }
}
