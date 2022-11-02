<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

trait TraceLogException
{
    /**
     * @param Exception $exception
     * @param string $function
     * @param bool $requestFlag
     * @return string|void
     */
    public function showLogError(Exception $exception, $function = '', $requestFlag = true): string
    {
        Log::error("
        FILE     ::  {$exception->getFile()}
        FUNCTION ::  $function()
        ERROR    ::  {$exception->getMessage()}
        LINE     ::  {$exception->getLine()}
        CODE     ::  {$exception->getCode()}
        REQUEST  ::  " . ($requestFlag ? $this->getRequestExcept() : 'NULL'));
        if (getenv('APP_DEBUG', false)) {
            return "
                FILE     ::  {$exception->getFile()}
                FUNCTION ::  $function()
                ERROR    ::  {$exception->getMessage()}
                LINE     ::  {$exception->getLine()}
                CODE     ::  {$exception->getCode()}
                REQUEST  ::  " . ($requestFlag ? $this->getRequestExcept() : 'NULL');
        }
        abort(VALIDATOR);
    }

    /**
     * @param Exception $exception
     * @param string $function
     * @param bool $requestFlag
     */
    public function writeLogError(Exception $exception, $function = '', $requestFlag = true)
    {
        Log::error("
        FILE     ::  {$exception->getFile()}
        FUNCTION ::  $function()
        ERROR    ::  {$exception->getMessage()}
        LINE     ::  {$exception->getLine()}
        CODE     ::  {$exception->getCode()}
        REQUEST  ::  " . ($requestFlag ? $this->getRequestExcept() : 'NULL'));
    }

    /**
     * @param Exception $exception
     * @param string $function
     * @param bool $requestFlag
     */
    public function writeLogWarning(Exception $exception, $function = '', $requestFlag = true)
    {
        Log::error("
        FILE     ::  {$exception->getFile()}
        FUNCTION ::  $function()
        WARNING  ::  {$exception->getMessage()}
        LINE     ::  {$exception->getLine()}
        CODE     ::  {$exception->getCode()}
        REQUEST  ::  " . ($requestFlag ? $this->getRequestExcept() : 'NULL'));
    }

    /**
     * @param Exception $exception
     * @param string $function
     * @param bool $requestFlag
     */
    public function writeLogCritical(Exception $exception, $function = '', $requestFlag = true)
    {
        Log::error("
        FILE     ::  {$exception->getFile()}
        FUNCTION ::  $function()
        CRITICAL ::  {$exception->getMessage()}
        LINE     ::  {$exception->getLine()}
        CODE     ::  {$exception->getCode()}
        REQUEST  ::  " . ($requestFlag ? $this->getRequestExcept() : 'NULL'));
    }

    /**
     * @param Exception $exception
     * @param string $function
     * @param bool $requestFlag
     * @return JsonResponse
     */
    public function responseException(Exception $exception, $function = '', $requestFlag = true): JsonResponse
    {
        if ($exception->getCode() == VALIDATOR || $exception->getCode() == UNPROCESSABLE_ENTITY) {
            return response()->json([
                'errors' => [
                    'detail' => $exception->getMessage(),
                ],
                'status_code' => $exception->getCode()
            ], $exception->getCode());
        }

        $this->writeLogError($exception, $function);
        if (getenv('APP_DEBUG', false)) {
            return response()->json([
                'errors' => [
                    'FILE' => $exception->getFile(),
                    'FUNCTION' => $function . '()',
                    'ERROR' => $exception->getMessage(),
                    'LINE' => $exception->getLine(),
                    'CODE' => $exception->getCode(),
                    'REQUEST' => ($requestFlag ? $this->getRequestExcept() : 'NULL'),
                ]
            ], SEVER_ERROR);
        } else {
            return response()->json([
                'errors' => [
                    'ERROR' => __('Server Error'),
                    'CODE' => SEVER_ERROR,
                ]
            ], SEVER_ERROR);
        }
    }

    /**
     * @return string
     */
    private function getRequestExcept(): string
    {
        $request = request()->except([
            '_token',
            'admin',
            'user',
            'password',
            'confirm_password',
            'email',
            'phone',
        ]);
        return \GuzzleHttp\json_encode($request);
    }
}
