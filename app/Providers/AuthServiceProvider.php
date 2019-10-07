<?php

namespace App\Providers;

use App\Models\Permission\Permission;
use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //Verifica se o usuário é Administrador, caso sim retorna true
        Gate::before(function($user){
            if($user->tipo_usuario == 'Administrador'){
                return true;
            }
        });

        //Define as permissões do usuário atualmente logado
        $permissions = Permission::all();
        foreach($permissions as $permission){
            Gate::define($permission->nome, function(User $user) use ($permission){
                return $user->testPermission($user->id_usuario, $permission);
            });
        }
    }
}
