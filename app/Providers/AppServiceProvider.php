<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider {

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        //
        
        Validator::extend('requiredarray', function($field, $value, $parameters) {
             foreach ($value as $v) {
                if (empty($v)) {
                    return false;
                }
            }
            exit;
            return true;
        });

//        $this->app['validator']->extend('requiredarray', function ($attribute, $value, $parameters) {
//            foreach ($value as $v) {
//                if (empty($v)) {
//                    return false;
//                }
//            }
//            return true;
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }

}
