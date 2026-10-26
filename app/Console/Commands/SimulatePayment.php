<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use Illuminate\Console\Command;

class SimulatePayment extends Command
{
    protected $signature = 'nextstep:simulate-payment {id} {--failed : Simula un pago fallido}';

    protected $description = 'Solo local/testing: simula el resultado de un pago para la demostración académica';

    public function handle(): int
    {
        if (! app()->environment(['local', 'testing'])) {
            $this->error('La simulación está deshabilitada en este entorno.');

            return self::FAILURE;
        }
        $order = Subscription::find($this->argument('id'));
        if (! $order || $order->payment_status !== 'pending') {
            $this->error('La solicitud no existe o ya tiene un resultado.');

            return self::FAILURE;
        }
        $data = ['payment_method' => 'simulation', 'payment_status' => 'failed', 'status' => 'failed'];
        if (! $this->option('failed')) {
            $data = ['payment_method' => 'simulation', 'payment_status' => 'paid', 'status' => 'active', 'paid_at' => now(), 'started_at' => now(), 'ended_at' => now()->addMonthNoOverflow()];
        }
        $updated = Subscription::where('_id', (string) $order->getKey())->where('payment_status', 'pending')->update($data);
        if (! $updated) {
            $this->error('La solicitud ya cambió de estado.');

            return self::FAILURE;
        }
        $this->info('Resultado de PRUEBA registrado. No se realizó ningún cobro real.');

        return self::SUCCESS;
    }
}
