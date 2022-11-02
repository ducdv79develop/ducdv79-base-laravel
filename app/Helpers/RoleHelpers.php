<?php

namespace App\Helpers;

use Exception;
use Illuminate\Support\Facades\Log;

class RoleHelpers
{
    /**
     * @param $data
     * @return string
     */
    public static function can($data): string
    {
        $role = 'can:';
        return self::commonRole($role, $data);
    }

    /**
     * @param $data
     * @return string
     */
    public static function role($data): string
    {
        $role = 'role:';
        return self::commonRole($role, $data);
    }

    /**
     * @param $data
     * @return string
     */
    public static function permission($data): string
    {
        $role = 'permission:';
        return self::commonRole($role, $data);
    }

    /**
     * @param $data
     * @return string
     */
    public static function roleOrPermission($data): string
    {
        $role = 'role_or_permission:';
        return self::commonRole($role, $data);
    }

    /**
     * @param string $role
     * @param $data
     * @return string
     */
    private static function commonRole(string $role, $data): string
    {
        if ($data && !is_array($data)) {
            return $role . $data;
        }
        foreach ($data as $item) {
            $role .= '|' .$item;
        }
        return $role;
    }

    /**
     * @param $roles
     * @return string
     */
    public static function displayRoles($roles): string
    {
        try {
            if (empty($roles) || count($roles) < 0) {
                return '';
            }

            $result = '';
            $flagFirst = true;
            foreach ($roles as $role) {
                if (!$flagFirst) {
                    $result .= ' / ';
                }
                $result .= $role->display_name;
                $flagFirst = false;
            }
            return $result;
        } catch (Exception $exception) {
            Log::error(throwExceptionCustom($exception, '[RoleHelpers][displayRoles]'));
            return '';
        }
    }
}
