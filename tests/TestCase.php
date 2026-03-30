<?php

namespace LBHurtado\EmiCore\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use LBHurtado\EmiCore\EmiCoreServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'LBHurtado\\EmiCore\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app): array
    {
        return [
            EmiCoreServiceProvider::class,
            \Spatie\LaravelData\LaravelDataServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('data.validation_strategy', 'always');
        config()->set('database.default', 'testing');
        config()->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $migrationFiles = glob(__DIR__.'/../database/migrations/*.php');
        foreach ($migrationFiles as $migration) {
            (include $migration)->up();
        }
    }
}
