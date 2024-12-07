<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;	
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        //
        // $data['users'] = Auth::user();
        // dd($data['users']);
        // View::share('data',$data); 
    }
}
