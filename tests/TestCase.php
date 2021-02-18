<?php

namespace Rrvwmrrr\Auditor\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;
use Rrvwmrrr\Auditor\Auditor;
use Rrvwmrrr\Auditor\AuditServiceProvider;
use Rrvwmrrr\Auditor\Tests\Support\Models\Auditor as AuditorModel;

class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            AuditServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('auth.providers.users.model', AuditorModel::class);
        
        Auditor::$auditorModel = AuditorModel::class;

        include_once __DIR__.'/database/migrations/create_test_tables.php';
        (new \CreateTestTables())->up();
    }
}
