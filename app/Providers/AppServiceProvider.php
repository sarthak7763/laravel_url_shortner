<?php

namespace App\Providers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Define gates for dual role system
        Gate::define('manage-company', function (User $user, Company $company) {
            // Super admin can manage any company
            if ($user->hasRole('SuperAdmin')) {
                return true;
            }

            // Company admin can manage companies where they have admin role
            if ($user->hasRole('Admin') && $user->hasCompanyRole($company, 'admin')) {
                return true;
            }

            return false;
        });

        Gate::define('view-company-users', function (User $user, Company $company) {
            // Super admin can view any company users
            if ($user->hasRole('SuperAdmin')) {
                return true;
            }

            // Company admin/member can view their company users
            return $user->companies()->where('company_id', $company->id)->exists();
        });

        Gate::define('manage-company-users', function (User $user, Company $company) {
            // Super admin can manage any company users
            if ($user->hasRole('SuperAdmin')) {
                return true;
            }

            // Only company admins can manage users in their company
            return $user->hasRole('Admin') && $user->hasCompanyRole($company, 'admin');
        });
    }
}
