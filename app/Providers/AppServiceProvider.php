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
        }, 'La :attribute debe ser menor.');

        Validator::extend('validateFechaMayorDe18', function ($attribute, $value, $parameters, $validator) {
            $fechaNacimiento = new DateTime($value);
            $hace18Anios = new DateTime('-18 years');
            return $fechaNacimiento <= $hace18Anios;
        }, 'La :attribute no corresponder a una persona mayor de 18 años.');
    }
}
