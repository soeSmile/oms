<?php

namespace App\Providers;

use App\Enum\RoleEnum;
use Illuminate\Support\Facades\Gate;
use Laravel\Horizon\Horizon;
use Laravel\Horizon\HorizonApplicationServiceProvider;

class HorizonServiceProvider extends HorizonApplicationServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        parent::boot();

        // Horizon::routeSmsNotificationsTo('15556667777');
        // Horizon::routeMailNotificationsTo('example@example.com');
        // Horizon::routeSlackNotificationsTo('slack-webhook-url', '#channel');

        // Horizon::night();
    }

    /**
     * @return void
     */
    protected function gate(): void
    {
        Gate::define('viewHorizon', static function ($user) {
            return $user->roler === RoleEnum::Admin->value;
        });
    }
}
