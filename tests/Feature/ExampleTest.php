<?php

namespace Tests\Feature;

use App\Models\User; // Ensure correct namespace if you're using Laravel 8+ directory structure
use App\Models\Tenant; // Adjust the namespace as needed
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();

        // Configure in-memory database for testing
        // Assuming landlord and tenant migrations are separated and can run independently
        $this->configureInMemoryDatabase();
        $this->runLandlordMigrations();
        $this->runTenantMigrations();
    }

    protected function configureInMemoryDatabase()
    {
        config([
            'database.connections.landlord' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
            ],
            'database.connections.tenant' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
            ],
        ]);

    }

    protected function runLandlordMigrations()
    {
        $this->artisan('migrate', ['--database' => 'landlord', '--path' => 'database/migrations/landlord']);
    }

    protected function runTenantMigrations()
    {
        // Simulate tenant setup before running migrations
        // This assumes you have a way to set the tenant's connection as the default connection for its migrations
        // You might need to implement logic here to switch to the tenant connection based on your application's tenancy approach
        $this->artisan('migrate', ['--database' => 'tenant']);
    }

    /**
     * @test
     */
    public function itReturnsCurrentTenantAndListOfItsUsers()
    {
        // Create a tenant and switch to the tenant's environment
        $tenant = Tenant::factory()->create();
        $tenant->use(); // Ensure this method correctly configures the environment for the tenant

        // Create a user associated with the tenant
        User::factory()->create(); // Adjust based on your user-tenant relationship

        $response = $this->getJson('/users');

        // Adjust the expected JSON count based on your actual application logic
        // For example, if you're only creating one user, you might expect a count of 1
        $response->assertJsonCount(1, 'users');

        $response->assertJsonFragment([
            'name' => $tenant->name,
            'domain' => $tenant->domain,
        ]);
    }
}
