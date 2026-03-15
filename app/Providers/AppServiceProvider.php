<?php

namespace App\Providers;

use App\Models\Container;
use App\Models\Drink;
use App\Repositories\RepositoryManager;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->seedNonDatabaseStorage();
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );
    }

    protected function seedNonDatabaseStorage(): void
    {
        $driver = config('coffee-machine.storage');

        if ($driver === 'database') {
            return;
        }

        $containerRepo = RepositoryManager::make(Container::class, $driver);
        if (empty($containerRepo->all())) {
            foreach (config('coffee-machine.default_containers', []) as $data) {
                $containerRepo->create($data);
            }
        }

        $drinkRepo = RepositoryManager::make(Drink::class, $driver);
        if (empty($drinkRepo->all())) {
            foreach (config('coffee-machine.default_drinks', []) as $data) {
                $drinkRepo->create($data);
            }
        }
    }
}
