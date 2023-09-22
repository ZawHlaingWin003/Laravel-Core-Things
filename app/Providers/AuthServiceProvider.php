<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        Gate::define('post-gate', function($user, $post){
            // if($user->id !== $post->author_id){
            //     return false;
            //     // throw new AuthorizationException('You don\'t have permission to do this action!');
            // }

            // return true;

            // return $user->id == $post->author_id;

            return $user->id == $post->author_id
                    ? Response::allow()
                    : Response::deny('You don\'t have permission');
        });
    }
}
