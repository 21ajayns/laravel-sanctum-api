<?php

namespace App\Providers;

use App\Respositories\Interfaces\TaskRespositoryInterface;
use App\Respositories\TaskRespository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskRespositoryInterface::class, TaskRespository::class);
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
