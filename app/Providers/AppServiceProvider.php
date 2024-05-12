<?php

namespace App\Providers;

//mail verify
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;


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
        schema::defaultStringLength(191);
        Paginator::useBootstrap();

        VerifyEmail::toMailUsing(function ($notifiable, $url) {
            return (new MailMessage)
                ->subject('Bienvenid@ a JManager - Creacion y Verificacion de correo')
                ->success()
                ->greeting("Hola, Bienvenid@ ".$notifiable->name.' '.$notifiable->surname.' a Jmanager')
                ->line('Se le ha otorgado acceso a la aplicacion. Haga clic en el botón a continuación para verificar su dirección de correo.')
                ->line("Contraseña: 'nombre'+'apelido'(primera letra)+mes actual.")
                ->action('Verificar correo', $url)
                ->line("Recuerde Resetear contraseña para mayor seguridad")
                ->line('Si no creó una cuenta, no se requiere ninguna otra acción.')
                ->salutation("Saludos, Jmanager (DhSolutions)");
        });
    }
}
