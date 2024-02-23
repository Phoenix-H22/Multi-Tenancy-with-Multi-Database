<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tenant extends Model
{
    use HasFactory;
    /**
     * The connection name for the model.
     *
     * @var string|null
     */
    protected $connection = 'landlord';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Configure the tenant database connection dynamically.
     *
     * @return $this
     */
    public function configure()
    {
        // Set the tenant's database connection configuration dynamically
        config()->set('database.connections.tenant.database', $this->database);

        // Purge the existing 'tenant' connection to ensure it's no longer used
        DB::purge('tenant');

        // Reconnect using the new configuration
        DB::reconnect('tenant');

        // Make sure the schema builder is using the tenant connection
        Schema::connection('tenant')->getConnection()->reconnect();

        return $this;
    }

    /**
     * Set the current tenant instance globally accessible via the container.
     *
     * @return $this
     */
    public function use()
    {
        // Remove any existing 'tenant' instance from the application container
        app()->forgetInstance('tenant');

        // Bind this tenant instance into the application container making it globally accessible
        app()->instance('tenant', $this);

        // Optionally, set the default database connection to 'tenant'
        // This can be useful if most of your application's operations should run under the tenant connection by default
        DB::setDefaultConnection('tenant');

        return $this;
    }
}
