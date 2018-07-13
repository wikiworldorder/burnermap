<?php
namespace BurnerMap;

use Illuminate\Support\ServiceProvider;

class BurnerMapServiceProvider extends ServiceProvider
{
    public function boot()
    {
        require __DIR__ . '/routes.php';
        $this->publishes([
            __DIR__.'/Views'     => base_path('resources/views/vendor/burnermap'),
            __DIR__.'/Images'    => base_path('public/images'),
            __DIR__.'/Libraries' => base_path('public/lib'),
            __DIR__.'/Database/2018_07_09_000000_BurnerMap_create_tables.php'
                => base_path('database/migrations/2018_07_09_000000_BurnerMap_create_tables.php'),
            __DIR__.'/Database/BurnerMapSeeder.php' => base_path('database/seeds/BurnerMapSeeder.php'),
        ]);
    }
}