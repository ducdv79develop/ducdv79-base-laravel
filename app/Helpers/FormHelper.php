<?php

namespace App\Helpers;

class FormHelper
{
    /**
     * @param $attribute
     * @param array $model
     * @param null $default
     * @return mixed|null
     */
    public static function getValueInput($attribute, $model = array(), $default = null)
    {
        if (old($attribute)) return old($attribute);

        if (is_object($model)) return optional($model)->{$attribute};

        return $default;
    }

    /**
     * @param $attribute
     * @param array $model
     * @param null $default
     * @return false|mixed|string|null
     */
    public static function getValueDate($attribute, $model = array(), $default = null)
    {
        $value = self::getValueInput($attribute, $model, $default);
        if ($value) {
            $value = date('d/m/Y', strtotime($value));
        }
        return $value;
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $model
     * @param null $default
     * @return string
     */
    public static function checkedRadioCheckbox($attribute, $value, $model = array(), $default = null)
    {
        if (is_array(old($attribute)) && in_array($value, old($attribute))) return 'checked';

        if (!is_null(old($attribute)) && old($attribute) == $value) return 'checked';

        if (is_object($model) && optional($model)->{$attribute} == $value) return 'checked';

        if ($default == $value) return 'checked';

        return '';
    }

    /**
     * @param $attribute
     * @param $value
     * @param array $model
     * @param null $default
     * @return string
     */
    public static function checkSelected($attribute, $value, $model = array(), $default = null)
    {
        if (!is_null(old($attribute)) && old($attribute) == $value) return 'selected';

        if (is_object($model) && optional($model)->{$attribute} == $value) return 'selected';

        if ($default == $value) return 'selected';

        return '';
    }
}
