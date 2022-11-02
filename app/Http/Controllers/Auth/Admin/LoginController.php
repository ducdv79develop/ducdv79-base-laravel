<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Config\AppConstants;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    /**
     * @var $pathView
     */
    protected $pathView = 'auth.admin.';

    /**
     * @var string
     */
    protected $guard = 'admin';

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * @return Guard|mixed
     */
    public function guard()
    {
        return Auth::guard($this->guard);
    }

    /**
     * Custom Login Param
     * @return string
     */
    public function username()
    {
        return 'phone';
    }

    /**
     * Show form login
     *
     * @return RedirectResponse|View
     */
    public function showLoginForm()
    {
        if ($this->guard()->check()) {
            return redirect()->route('admin.home');
        }
        return view($this->pathView . 'login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param Request $request
     * @return Response|void
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            $admin = $this->guard()->user();
            $current = Carbon::now(config('app.timezone'))->format('Y-m-d');

            if ($admin->status != AppConstants::ADM_STATUS_ACTIVE) {

                $this->logout($request);
                session()->flash(SESSION_FAIL, 'Tài khoản của bạn đã bị khóa !');

            } elseif ($admin->timeout < $current) {

                $this->logout($request);
                session()->flash(SESSION_FAIL, 'Tài khoản của bạn đã hết hạn !');

            } else {
                return redirect()->intended('admin/home');
            }

        } else {
            session()->flash(SESSION_FAIL, 'Tài khoản mật khẩu không chính xác.');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Logout Admin
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.form_login');
    }
}
