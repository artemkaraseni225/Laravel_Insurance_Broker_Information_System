<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Gates — быстрая проверка "какая у пользователя роль",
        // без привязки к конкретной записи
        Gate::define('is-admin', fn ($user) => $user->role?->name === 'admin');
        Gate::define('is-broker', fn ($user) => $user->role?->name === 'broker');
        Gate::define('is-customer', fn ($user) => $user->role?->name === 'customer');

        // Policy — привязана к конкретной записи ("это ИМЕННО ТВОЙ профиль,
        // а не чужой"). Когда появятся Application/Document — добавим
        // ApplicationPolicy/DocumentPolicy по тому же принципу.
        Gate::policy(User::class, UserPolicy::class);
    }
}
