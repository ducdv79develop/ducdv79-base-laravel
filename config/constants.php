<?php
//200: Ok
const SUCCESS = 200;
// 201: Create Success
const STORE_SUCCESS = 200;
// 204: Delete
const DELETE_SUCCESS = 204;
// 400. NOT FOUND
const VALIDATOR = 400;
// 401: Unauthorized.
const UNAUTHORIZED = 401;
// 403: Forbidden.
const FORBIDDEN = 403;
// 404: Not found.
const NOTFOUND = 404;
// 412: Precondition Failed.
const PRECONDITION_FAILED = 412;
// 412: Page Expired.
const PAGE_EXPIRED = 419;
// 422: Unprocessable entity
const UNPROCESSABLE_ENTITY = 422;
// 500: Internal server error.
const SEVER_ERROR = 500;
// 503: Service unavailable.
const SERVER_UNAVAILABLE = 503;
// key session
const SESSION_SUCCESS = 'success';
const SESSION_FAIL = 'fail';
const SESSION_WARNING = 'warning';
const SESSION_INFO = 'info';
const API_ERROR = 'SERVER ERROR';
const API_FAIL = 'Request Failed';
const API_SUCCESS = 'Request Success';
const PER_PAGE = 15;
const ZERO_VALUE = 0;
// setting web admin
const SYSTEM_MANAGEMENT_ADMIN_ID = 1;
const ADM_TEAM_ID = 'adm_team_id';
const ADM_LEADER_ID = 0;
// define role constant
const GUARD_ROLE_ADMIN = 'admin';
const GUARD_ROLE_USER = 'user';
const ROLE_SYSTEM_MANAGEMENT = 'system_management';
const ROLE_ADMIN = 'admin';
const ROLE_FINANCE = 'finance';
const ROLE_CENSOR = 'censor';
const ROLE_SALESMAN = 'salesman';
// define permission group constant
const PER_GROUP_ROLE = 'role';
const PER_GROUP_ADMIN = 'admin';
const PER_GROUP_ANALYSE = 'analyse';
const PER_GROUP_PROJECT = 'project';
const PER_GROUP_BORROWER = 'borrower';
const PER_GROUP_TRANSACTION = 'transaction';
const PER_GROUP_PRODUCT = 'product';
const PER_GROUP_CATEGORY = 'category';
const PER_GROUP_ORDER = 'order';
// define permission action constant
const PER_ACTION_READ = 'read';
const PER_ACTION_WRITE = 'write';
const PER_ACTION_OTHER = 'other';
// define permission other constant

// define cookie key
const COOKIE_KEY_ALL = 'all';
const COOKIE_CART_KEY = 'cart_key';
const COOKIE_CUS_LOGIN_REDIRECT = 'login_redirect';
