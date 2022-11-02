<?php

namespace App\Http\Controllers;

use App\Traits\TraceLogException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * use trace log exception custom
     */
    use TraceLogException;

    /**
     * Return Response When Use Ajax
     * @param bool $status
     * @param string $msg
     * @param null $data
     * @return JsonResponse
     */
    public function jsonResponse($status = true, $msg = '', $data = null): JsonResponse
    {
        $response = [
            'status' => $status,
            'msg' => $msg,
        ];
        if ($data) $response['data'] = $data;
        return response()->json($response);
    }

    /**
     * @param $request
     * @param $datas
     * @param $url_redirect
     * @return RedirectResponse
     */
    public function redirectLastPage($request, $datas, $url_redirect): RedirectResponse
    {
        $currentPage = (int)$request->get('page');
        $lastPage = $datas->lastPage();
        if ($currentPage > $lastPage) {
            return redirect()->route($url_redirect, ['page' => $lastPage]);
        }
        return redirect()->route($url_redirect, ['page' => $currentPage]);
    }

    /**
     * @param $datas
     * @param $pathView
     * @param array $dataArray
     * @return array|string
     * @throws Throwable
     */
    public function renderHtml($datas, $pathView, $dataArray = array())
    {
        return view($pathView, compact('datas', 'dataArray'))->render();
    }

    /**
     * @param Request $request
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     * @return Validator
     */
    public function validateRequest(Request $request, array $rules, array $messages = [], array $customAttributes = []): Validator
    {
        return $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages, $customAttributes);
    }
}
