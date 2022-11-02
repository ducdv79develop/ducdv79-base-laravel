<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Config\AppConstants;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Mockery\Exception;

class SocialiteController extends Controller
{
    /**
     * @var string
     */
    protected $driver;
    /**
     * @var string
     */
    protected $guard;
    /**
     * @var Model
     */
    protected $model;
    /**
     * @var string
     */
    protected $redirectTo = '/';
    /**
     * @var null
     */
    protected $cookieUrlCallback = null;

    /**
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver($this->driver)->redirect();
    }

    /**
     * @return RedirectResponse
     */
    public function callback(): RedirectResponse
    {
        try {
            $userInfo = Socialite::driver($this->driver)->user();
            $user = $this->getOrCreate($userInfo);
            if (is_object($user)) Auth::guard($this->guard)->login($user);
            $this->processingActionsAfterLogin();

        } catch (Exception $exception) {
            $this->writeLogError($exception, 'SocialiteController::callback', false);
        } finally {
            $callback = $this->cookieUrlCallback ? getCookieSite($this->cookieUrlCallback) : null;
            return redirect()->to($callback ?? $this->redirectTo);
        }
    }

    /**
     * processing actions after login
     */
    public function processingActionsAfterLogin()
    {
        // TODO: processing actions after login
    }

    /**
     * @param $url
     */
    public function setRedirectTo($url)
    {
        $this->redirectTo = $url;
    }

    /**
     * @param $key
     */
    public function setCookieUrlCallback($key)
    {
        $this->cookieUrlCallback = $key;
    }

    /**
     * @param $model
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @param ProviderUser $userInfo
     * @return mixed
     */
    public function getOrCreate(ProviderUser $userInfo)
    {
        $account = $this->model->query()
            ->where('provider_user_id' , $userInfo->getId())
            ->where('provider', $this->driver)
            ->first();
        if ($account) return $account;

        return $this->model->create([
            'provider_user_id' => $userInfo->getId(),
            'provider' => $this->driver,
            'avatar' => $userInfo->getAvatar(),
            'email' => $userInfo->getEmail(),
            'name' => $userInfo->getName(),
            'phone' => null,
            'verified' => AppConstants::CUS_VERIFIED_TRUE,
            'verified_at' => Carbon::now(),
        ]);
    }
}
