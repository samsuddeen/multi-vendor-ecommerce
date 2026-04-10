<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Admin;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
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
        // one
        Fortify::authenticateUsing(function (Request $request) {
            if (!str_starts_with($request->path(), 'admin')) {
                return null;
            }

            $admin = Admin::where('email', $request->email)->first();
            if (!$admin) {
                throw ValidationException::withMessages([
                    'email' => 'Invalid credentials',
                ]);
            }

            if ($admin->isLocked()) {
                throw ValidationException::withMessages([
                    'account' => 'account is locked',
                ]);
            }
            if (!$admin->status) {
                throw ValidationException::withMessages([
                    'status' => 'status inactive',
                ]);
            }

            // if($admin && Hash::check($request->password, $admin->password))
            //     {
            //         return $admin;
            //     }
            //     else {
            //     $admin->recordFailedLogin();
            //     return null;
            //     }

            //     $admin->recordSuccessfulLogin($request->ip());

            if (!Hash::check($request->password, $admin->password)) {
                $admin->recordFailedLogin();
                throw ValidationException::withMessages([
                    'password' => 'Invalid password',
                ]);
            }

            $admin->recordSuccessfulLogin($request->ip());

            return $admin;
        });

        // 2nd
        Fortify::loginView(
            fn(Request $r) => str_starts_with($r->path(), 'admin')
                ? view('admin.auth.login') : view('auth.login')
        );

        //2fa
        Fortify::twoFactorChallengeView(
            fn(Request $r) => str_starts_with($r->path(), 'admin')
                ? view('admin.auth.two-factor') : view('auth.two-factor')
        );





        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())) . '|' . $request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
    }
}
