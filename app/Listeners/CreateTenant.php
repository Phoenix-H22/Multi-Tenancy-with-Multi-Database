<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class CreateTenant
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $tenant = $event->tenant;
        DB::statement("CREATE DATABASE {$tenant->database}");

        $tenant->configure()->use();
        Artisan::call('tenants:migrate '.$tenant->id.' --seed');
    }
}
