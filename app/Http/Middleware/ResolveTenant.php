<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ResolveTenant
{
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        if ($host == env('LANDLORD_DOMAIN'))
        {
            dd(DB::connection('landlord')->getDatabaseName());

            DB::reconnect('landlord');
            dd(config('database.connections.landlord'), DB::connection()->getDatabaseName());

            app()->instance('tenant', json_decode(json_encode(['id' => 0, 'name' => 'Landlord'])));
            dd(User::all());
            return $next($request);
        }
        $tenant = Tenant::where('domain', $host)->firstOrFail();
        $tenant->configure()->use();
        app()->instance('tenant', $tenant);
        Config::set('database.connections.tenant.database', $tenant->database);
        DB::reconnect('tenant');

        return $next($request);
    }
}
