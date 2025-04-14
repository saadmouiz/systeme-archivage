<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

     
    public function boot()
    {
        $this->registerPolicies();

        // Définir les accès pour Admin1 (financiers, administratifs, RH, employés)
        Gate::define('access-admin1-sections', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin1');
        });

        // Définir les accès pour Admin2 (bénéficiaires, partenaires, événements et communication)
        Gate::define('access-admin2-sections', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin2');
        });

        // Contrôle d'accès spécifique pour chaque section
        Gate::define('access-financiers', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin1');
        });

        Gate::define('access-administratifs', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin1');
        });

        Gate::define('access-rh', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin1');
        });

        Gate::define('access-employes', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin1');
        });


        Gate::define('access-beneficiaires', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin2') || $user->hasRole('admin3'); 
        });
        Gate::define('access-pointages', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin3'); 
        
        });

// Permissions spécifiques pour les pointages
Gate::define('view_pointages', function ($user) {
    return $user->hasRole('superadmin') || $user->hasRole('admin3');
});

Gate::define('create_pointages', function ($user) {
    return $user->hasRole('superadmin') || $user->hasRole('admin3');
});

Gate::define('store_pointages', function ($user) {
    return $user->hasRole('superadmin') || $user->hasRole('admin3') ;
});

Gate::define('view_employee_pointages', function ($user) {
    return $user->hasRole('superadmin') || $user->hasRole('admin3') ;
});

Gate::define('export_pointages', function ($user) {
    return $user->hasRole('superadmin') || $user->hasRole('admin3') ;
});
        

Gate::define('access-partenaires', function ($user) {
    return $user->hasRole('superadmin');
});


        Gate::define('access-communications', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin2');
        });

        Gate::define('access-evenements', function ($user) {
            return $user->hasRole('superadmin') || $user->hasRole('admin2');
        });
    }
}