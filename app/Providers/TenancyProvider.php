<?php

namespace App\Providers;

use App\Models\Tenant; // Ensure your models are correctly namespaced (Laravel 8+ recommends `Models` directory).
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event; // Laravel 8+ encourages the use of facades.
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;

class TenancyProvider extends ServiceProvider
{

    /**
     * Configure the application for the current tenant based on the request.
     */
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // You can bind services here if needed
    }

    /**
     * Bootstrap services.
     *
     * Application bootstrapping code here.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function boot(Request $request)
    {
        $host = $request->getHost();

        if ($host == env('LANDLORD_DOMAIN')) {
            $this->configureLandlord();
        }
        else if($this->app->runningInConsole())
        {
            $this->configureLandlord();
        }
        else {
            $this->configureTenant($host);
        }

    }

    protected function configureLandlord()
    {
        Config::set('database.default', 'landlord');
        DB::reconnect('landlord');

        // Setting a default instance for 'tenant' to prevent errors
        // when accessing 'tenant' specific data on the landlord domain
        app()->instance('tenant', json_decode(json_encode(['id' => 0, 'name' => 'Landlord'])));
    }

    protected function configureTenant($host)
    {
        $host = explode('.', $host)[0];
        $tenant = Tenant::where('domain', $host)->firstOrFail();
        $tenant->configure()->use(); // Assuming this method sets the DB connection
        app()->instance('tenant', $tenant);
    }


}
