<?php

namespace App\Config;

class AppConstants
{
    const
        // Admin const
        ADM_PASSWORD_DEFAULT = 123456,
        ADM_TIMEOUT_FREE = 7,
        ADM_TIMEOUT_FREE_TRUE = 1,
        ADM_STATUS_ACTIVE = 0,
        ADM_STATUS_BLOCK = 1,
        ADM_KEY_REQUEST = 'admin_obj',

        // Images const
        IMG_TYPE_NONE = 0,
        IMG_TYPE_PRODUCT = 1,
        IMG_TYPE_CATEGORY = 2,
        IMG_TYPE_EVENT = 3,
        IMG_TYPE_BANNER = 4,

        // Customer
        CUS_VERIFIED_TRUE = 1,
        CUS_VERIFIED_FALSE = 0,

        // Common const
        DISPLAY_FLAG_TRUE = 1,
        DISPLAY_FLAG_FALSE = 0,
        DEFAULT_FLAG_TRUE = 1,
        DEFAULT_FLAG_FALSE = 0,
        DELETE_FLAG_TRUE = 1,
        DELETE_FLAG_FALSE = 0,
        PUBLIC_FLAG_TRUE = 1,
        PUBLIC_FLAG_FALSE = 0,
        GENDER_MALE = 1,
        GENDER_FEMALE = 2,
        DEFINE_ACTION_REQUEST = 'act'
    ;
}
