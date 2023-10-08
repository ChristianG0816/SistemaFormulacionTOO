<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use DateTime;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('fecha_menor_igual', function ($attribute, $value, $parameters, $validator) {
            $fechaFin = $validator->getData()[$parameters[0]];
            return strtotime($value) <= strtotime($fechaFin);
        }, 'The :attribute must be less');

        Validator::extend('validateFechaMayorDe18', function ($attribute, $value, $parameters, $validator) {
            $fechaNacimiento = new DateTime($value);
            $hace18Anios = new DateTime('-18 years');
            return $fechaNacimiento <= $hace18Anios;
        }, 'The :attribute not correspond to a person over 18 years of age.');
    }
}
