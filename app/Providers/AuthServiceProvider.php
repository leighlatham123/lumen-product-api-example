<?php

namespace App\Providers;

use Exception;
use App\Models\User;
use App\Services\RequestService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;
use App\Exceptions\ApiAuthenticationException;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest(
            'api', function ($request) {
                $username = $_SERVER['PHP_AUTH_USER'];
                $password = $_SERVER['PHP_AUTH_PW'];

                (new RequestService())->getRequestLocalization($request);

                try
                {
                    $user = User::whereUserName($username)->firstOrFail();

                    if (!Hash::check($password, $user->user_password)) {
                        throw new Exception();
                    }

                    return $user;
                }
                catch(Exception $e)
                {
                    throw new ApiAuthenticationException(__(config("constants.messages.errors.incorrect_auth")));
                }
            }
        );
    }
}
