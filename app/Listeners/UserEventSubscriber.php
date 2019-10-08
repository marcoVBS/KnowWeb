<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Auth;

class UserEventSubscriber
{
    /**
     * Handle user login events.
     */
    public function onUserLogin($event)
    {
        // Verifica se o usuário está ativo
        if(auth()->user()->status == 0){
            
            Auth::logout();
            abort(403, 'O usuário correspondente às credenciais informadas está inativo. Entre em contato com o administrador do sistema!');
             
        }
    }
 
 
    /**
     * Handle user logout events.
     */
    public function onUserLogout($event)
    {
        // Se quiser implementar algo pós logout é neste estágio
        //dd($event);
    }
 
 
    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'Illuminate\Auth\Events\Login',
            'App\Listeners\UserEventSubscriber@onUserLogin'
        );
 
        $events->listen(
            'Illuminate\Auth\Events\Logout',
            'App\Listeners\UserEventSubscriber@onUserLogout'
        );
    }
 
}