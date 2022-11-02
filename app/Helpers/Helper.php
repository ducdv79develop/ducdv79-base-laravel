<?php

use App\Models\Admin;
use App\Models\Customer;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

const CUSTOMER = 'web';
const USER = 'user';
const ADMIN = 'admin';
const PREFIX_SECURE = '';

if (!function_exists('module_path')) {
    function module_path($name, $path = ''): string
    {
        $basePath = base_path("app_modules/$name");
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $directory = new DirectoryIterator($basePath);
            $basePath = $directory->getRealPath();
        }
        return $basePath . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}

if (!function_exists('setCookieSite')) {

    function setCookieSite($key, $value, $expireTime = null)
    {
        if (empty($expireTime)) {
            $expireTime = config('settings.cookie.expire_time_1_month');
        }
        Cookie::queue(Cookie::make(PREFIX_SECURE . $key, $value, $expireTime));
    }
}

if (!function_exists('setCookieSiteArr')) {

    function setCookieSiteArr($keyMain, $value = [], $expireTime = null)
    {
        $cookieBefore = !empty(Cookie::get(PREFIX_SECURE . $keyMain)) ? \GuzzleHttp\json_decode(Cookie::get(PREFIX_SECURE . $keyMain), true) : [];
        $cookieSet = array_merge($cookieBefore, $value);
        if (empty($expireTime)) {
            $expireTime = config('settings.cookie.expire_time_1_month');
        }
        Cookie::queue(Cookie::make(PREFIX_SECURE . $keyMain, \GuzzleHttp\json_encode($cookieSet), $expireTime));
    }
}

if (!function_exists('getCookieSite')) {
    function getCookieSite($key = COOKIE_KEY_ALL, $default = null)
    {
        if ($key === COOKIE_KEY_ALL) {
            return Cookie::get();
        } else {
            return Cookie::get(PREFIX_SECURE . $key) ?? $default;
        }
    }
}

if (!function_exists('getCookieSiteArr')) {
    function getCookieSiteArr($keyMain, $key = null, $default = null)
    {
        $cookieData = Cookie::get(PREFIX_SECURE . $keyMain);
        if (!empty($cookieData)) {
            $data = \GuzzleHttp\json_decode($cookieData);
            if (empty($key)) return $data;

            return $data->{$key} ?? $default;
        }
        return $cookieData;
    }
}

if (!function_exists('forgetCookieSite')) {
    function forgetCookieSite($key)
    {
        $cookieData = Cookie::get(PREFIX_SECURE . $key);
        if (!empty($cookieData)) {
            Cookie::queue(Cookie::forget(PREFIX_SECURE . $key));
        }
    }
}

if (!function_exists('user')) {
    /**
     * @return Guard|StatefulGuard
     */
    function user()
    {
        return Auth::guard(USER);
    }
}

if (!function_exists('userCheck')) {
    /**
     * @return bool
     */
    function userCheck(): bool
    {
        return Auth::guard(USER)->check();
    }
}

if (!function_exists('userInfo')) {
    /**
     * @param null $attribute
     * @return Authenticatable|null|string
     */
    function userInfo($attribute = null)
    {
        $user = request()->get('user', null);
        if (empty($user)) {
            $user = Auth::guard(USER)->user();
        }

        if ($attribute) {
            return $user->{$attribute};
        }
        return $user;
    }
}

if (!function_exists('admin')) {
    /**
     * @return Guard|StatefulGuard
     */
    function admin()
    {
        return Auth::guard(ADMIN);
    }
}

if (!function_exists('adminCheck')) {
    /**
     * @return bool
     */
    function adminCheck(): bool
    {
        return Auth::guard(ADMIN)->check();
    }
}

if (!function_exists('adminInfo')) {
    /**
     * @param null $attribute
     * @return Authenticatable|null|string|Admin
     */
    function adminInfo($attribute = null)
    {
        $admin = request()->get('admin', null);
        if (empty($admin)) {
            $admin = Auth::guard(ADMIN)->user()/*->load(['teams', 'teamLeader'])*/
            ;
        }

        if ($attribute) {
            return $admin->{$attribute};
        }
        return $admin;
    }
}

if (!function_exists('customer')) {
    /**
     * @return Guard|StatefulGuard
     */
    function customer()
    {
        return Auth::guard(CUSTOMER);
    }
}

if (!function_exists('customerCheck')) {
    /**
     * @return bool
     */
    function customerCheck(): bool
    {
        return Auth::guard(CUSTOMER)->check();
    }
}

if (!function_exists('customerInfo')) {
    /**
     * @param null $attribute
     * @return Authenticatable|null|string|Customer
     */
    function customerInfo($attribute = null)
    {
        $customer = request()->get('customer', null);
        if (empty($customer)) {
            $customer = Auth::guard(CUSTOMER)->user();
        }

        if ($attribute) {
            return $customer->{$attribute};
        }
        return $customer;
    }
}

if (!function_exists('hasRead')) {
    /**
     * @param $group
     * @return string
     */
    function hasRead($group): string
    {
        return $group . '_' . PER_ACTION_READ;
    }
}

if (!function_exists('hasWrite')) {
    /**
     * @param $group
     * @return string
     */
    function hasWrite($group): string
    {
        return $group . '_' . PER_ACTION_WRITE;
    }
}

if (!function_exists('hasOther')) {
    /**
     * @param $group
     * @return string
     */
    function hasOther($group): string
    {
        return $group . '_' . PER_ACTION_OTHER;
    }
}

if (!function_exists('checkHasRead')) {
    /**
     * @param $group
     * @param string $guard
     * @return bool
     */
    function checkHasRead($group, $guard = GUARD_ROLE_ADMIN): bool
    {
        switch ($guard) {
            case GUARD_ROLE_ADMIN;
                $model = adminInfo();
                break;
            case GUARD_ROLE_USER:
                $model = userInfo();
                break;
            default:
                return false;
        }
        return $model->can(hasRead($group));
    }
}

if (!function_exists('checkHasWrite')) {
    /**
     * @param $group
     * @param string $guard
     * @return bool
     */
    function checkHasWrite($group, $guard = GUARD_ROLE_ADMIN): bool
    {
        switch ($guard) {
            case GUARD_ROLE_ADMIN;
                $model = adminInfo();
                break;
            case GUARD_ROLE_USER:
                $model = userInfo();
                break;
            default:
                return false;
        }
        return $model->can(hasWrite($group));
    }
}

if (!function_exists('checkHasOther')) {
    /**
     * @param $group
     * @param string $guard
     * @return bool
     */
    function checkHasOther($group, $guard = GUARD_ROLE_ADMIN): bool
    {
        switch ($guard) {
            case GUARD_ROLE_ADMIN;
                $model = adminInfo();
                break;
            case GUARD_ROLE_USER:
                $model = userInfo();
                break;
            default:
                return false;
        }
        return $model->can(hasOther($group));
    }
}

if (!function_exists('checkHasPermission')) {
    /**
     * @param $permissions
     * @param string $guard
     * @return bool
     */
    function checkHasPermission($permissions, $guard = GUARD_ROLE_ADMIN): bool
    {
        switch ($guard) {
            case GUARD_ROLE_ADMIN;
                $model = adminInfo();
                break;
            case GUARD_ROLE_USER:
                $model = userInfo();
                break;
            default:
                return false;
        }
        return $model->can($permissions);
    }
}

if (!function_exists('checkHasRole')) {
    /**
     * @param $roles
     * @param string $guard
     * @return bool
     */
    function checkHasRole($roles, $guard = GUARD_ROLE_ADMIN): bool
    {
        switch ($guard) {
            case GUARD_ROLE_ADMIN;
                $model = adminInfo();
                break;
            case GUARD_ROLE_USER:
                $model = userInfo();
                break;
            default:
                return false;
        }
        return $model->hasRole($roles);
    }
}

if (!function_exists('middlePermission')) {
    /**
     * @param array|string $permissions
     * @return string
     */
    function middlePermission($permissions): string
    {
        if (empty($permissions)) {
            return "";
        }
        $guard = GUARD_ROLE_ADMIN;
        $permission = '';
        if (is_array($permissions)) {
            foreach ($permissions as $index => $per) {
                $permission .= $per;
                if ($index != (count($permissions) - 1)) {
                    $permission .= "|";
                }
            }
        } else {
            $permission = $permissions;
        }
        return "permission:{$permission},{$guard}";
    }
}

if (!function_exists('middleRoles')) {
    /**
     * @param array|string $roles
     * @return string
     */
    function middleRoles($roles): string
    {
        if (empty($roles)) {
            return '';
        }
        if (is_array($roles)) {
            $role = '';
            foreach ($roles as $index => $role) {
                $role .= $role;
                if ($index != (count($roles) - 1)) {
                    $role .= "|";
                }
            }
        } else {
            $role = $roles;
        }
        $guard = GUARD_ROLE_ADMIN;
        return "role:{$role},{$guard}";
    }
}

if (!function_exists('middleRoleOrPer')) {
    /**
     * @param string|array $roleOrPermissions
     * @return string
     */
    function middleRoleOrPer($roleOrPermissions): string
    {
        if (empty($roleOrPermissions)) {
            return '';
        }
        $roleOrderPermission = '';
        $guard = GUARD_ROLE_ADMIN;
        if (is_array($roleOrPermissions)) {
            foreach ($roleOrPermissions as $index => $role) {
                $roleOrderPermission .= $role;
                if ($index != (count($roleOrPermissions) - 1)) {
                    $roleOrderPermission .= "|";
                }
            }
        } else {
            $roleOrderPermission = $roleOrPermissions;
        }
        return "role_or_permission:{$roleOrderPermission},{$guard}";
    }
}

if (!function_exists('classInvalid')) {
    /**
     * @param $attribute
     * @param $errors
     * @return string|null
     */
    function classInvalid($attribute, $errors): ?string
    {
        if (!empty($errors->first($attribute))) {
            return 'is-invalid';
        }
        return '';
    }
}

if (!function_exists('showErrorHtml')) {
    /**
     * @param $attribute
     * @param $errors
     * @return string|null
     */
    function showErrorHtml($attribute, $errors): ?string
    {
        if (!empty($errors->first($attribute))) {
            return '<p id="' . $attribute . '-error" class="is-invalid">' . $errors->first($attribute) . '</p>';
        }
        return '';
    }
}

if (!function_exists('oldValue')) {
    /**
     * @param $attribute
     * @return string|null
     */
    function oldValue($attribute): ?string
    {
        return old($attribute) ?? request($attribute);
    }
}

if (!function_exists('transCustomValidate')) {
    /**
     * @param $validate
     * @param $attribute
     * @param null $param1
     * @param null $param2
     * @return string|null
     */
    function transCustomValidate($validate, $attribute, $param1 = null, $param2 = null): ?string
    {
        $data = [
            'attribute' => __($attribute)
        ];
        if (strpos($validate, 'between') >= 0) {
            $data['min'] = $param1;
            $data['max'] = $param2;
        }
        if (strpos($validate, 'max') >= 0) {
            $data['max'] = $param1;
        }
        if (strpos($validate, 'min') >= 0) {
            $data['min'] = $param1;
        }
        return __('validation.' . $validate, $data);
    }
}

if (!function_exists('escapeLike')) {
    /**
     * @param $attribute
     * @param bool $getRequest
     * @return string
     */
    function escapeLike($attribute, bool $getRequest = false): string
    {
        if ($getRequest) {
            $attribute = request()->get($attribute);
        }
        $arySearch = array('\\', '%', '_');
        $aryReplace = array('\\\\', '\%', '\_');
        return str_replace($arySearch, $aryReplace, $attribute);
    }
}

if (!function_exists('throwExceptionCustom')) {
    /**
     * @param Exception $exception
     * @param $functionName
     * @return string
     */
    function throwExceptionCustom(Exception $exception, $functionName = ''): string
    {
        return $functionName . " ERROR: {$exception->getMessage()} , LINE: {$exception->getLine()}";
    }
}

if (!function_exists('routeDomain')) {
    /**
     * @param $routeName
     * @param $domain
     * @param array $params
     * @param bool $ssl
     * @return string
     */
    function routeDomain($routeName, $domain, $params = [], $ssl = false): string
    {
        try {
            $path = route($routeName, $params, false);
            $http = substr($domain, 0, 7);
            $https = substr($domain, 0, 8);
            if ($http !== 'http://' && $https !== 'https://') {
                $domain = ($ssl ? 'https://' : 'http://') . $domain;
            }

            return $domain . $path;

        } catch (Exception $exception) {
            Log::error("Helper::routeDomain() ERROR: {$exception->getMessage()}");
            return '#';
        }
    }
}

if (!function_exists('checkRequest')) {
    /**
     * @param $keyword
     * @param null $request
     * @param null $checks
     * @return boolean
     */
    function checkRequest($keyword, $request = null, $checks = null): bool
    {
        if ($request !== null) {
            $value = $request->get($keyword);
        } else {
            $value = request()->get($keyword);
        }
        if(is_null($checks)) return !($value === null || trim($value) === "");

        if (is_array($checks)) return in_array($value, $checks);

        return $value == $checks;
    }
}

if (!function_exists('asset_custom')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  $path
     * @return string
     */
    function asset_custom($path): string
    {
        $host = request()->getHttpHost();
        $secure = null;
        $settings = config('settings.domain');
        if (is_array($settings)) {
            foreach ($settings as $key => $value) {
                if ($value == $host) {
                    $secure = $settings["ssl_$key"] ?? null;
                    break;
                }
            }
        }

        return app('url')->asset($path, $secure);
    }
}
