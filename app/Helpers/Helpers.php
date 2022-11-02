<?php

namespace App\Helpers;

class Helpers
{
    /**
     * @param $needle
     * @param $haystack
     * @return bool
     */
    public static function shapeSpace_search_array($needle, $haystack)
    {
        if (in_array($needle, $haystack)) {
            return true;
        }
        foreach ($haystack as $item) {
            if (is_array($item) && array_search($needle, $item))
                return true;
        }
        return false;
    }

    /**
     * @param $group
     * @param $action
     * @return string
     */
    public static function getPermission($group, $action): string
    {
        return $group . '_' . $action;
    }

    /**
     * @param $datetime
     * @param bool $seconds
     * @return false|string
     */
    public static function formatDatetime($datetime, $seconds = false)
    {
        if (empty($datetime)) return ($seconds ? "__:" : "") . "__:__ __/__/____";
        return date(($seconds ? "H:i:s d/m/Y" : "H:i d/m/Y"), strtotime($datetime));
    }

    /**
     * @param $code
     * @return string
     */
    public static function getPermissionText($code): string
    {
        $result = '';
        if (is_array($code)) {
            foreach ($code as $value) {
                if (strpos($value, PER_ACTION_READ)) {
                    $result .= "<span class='color--green'>" . __('message.role.permission.read') . "</span>&nbsp;&nbsp;";
                }
                if (strpos($value, PER_ACTION_WRITE)) {
                    $result .= "<span class='color--blue'>" . __('message.role.permission.write') . "</span>&nbsp;&nbsp;";
                }
                if (strpos($value, PER_ACTION_OTHER)) {
                    $result .= "<span class='color--red'>" . __('message.role.permission.other') . "</span>&nbsp;&nbsp;";
                }
            }
            return $result;
        }

        if (strpos($code, PER_ACTION_READ)) {
            $result = "<span class='color--green'>" . __('message.role.permission.read') . "</span>";
        }
        if (strpos($code, PER_ACTION_WRITE)) {
            $result = "<span class='color--blue'>" . __('message.role.permission.write') . "</span>";
        }
        if (strpos($code, PER_ACTION_OTHER)) {
            $result = "<span class='color--red'>" . __('message.role.permission.other') . "</span>";
        }
        return $result;
    }

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    public static function routeDomainAdmin($routeName, $params = []): string
    {
        $domain = config('settings.domain.admin');
        $ssl = config('settings.domain.ssl_admin');
        return routeDomain($routeName, $domain, $params, $ssl);
    }

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    public static function routeDomainShop($routeName, $params = []): string
    {
        $domain = config('settings.domain.shop');
        $ssl = config('settings.domain.ssl_shop');
        return routeDomain($routeName, $domain, $params, $ssl);
    }

    /**
     * @param $routeName
     * @param array $params
     * @return string
     */
    public static function routeDomainFinance($routeName, $params = []): string
    {
        $domain = config('settings.domain.finance');
        $ssl = config('settings.domain.ssl_finance');
        return routeDomain($routeName, $domain, $params, $ssl);
    }

}
