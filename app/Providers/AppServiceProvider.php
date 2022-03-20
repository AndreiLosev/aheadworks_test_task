<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services;
use App\Repository;
use App\Models;
use App\Mail;
use App\Jobs;
use Illuminate\Contracts\Hashing\Hasher;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Services\Auth::class, function($app) {
            return new Services\Auth(
                $app->make(Repository\UserRepository::class),
                $app->make(Hasher::class),
            );
        });

        $this->app->when(Services\Tiket::class)
            ->needs(\Closure::class)
            ->give(function() {
                return function(Models\Ticket $tiket, Mail\NewTiket $tiketMail) {
                    Jobs\AfterCreateTiket::dispatch($tiket, $tiketMail);
                };
            });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
