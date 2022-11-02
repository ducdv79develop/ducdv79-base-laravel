<?php

namespace Packages\Vietnamzone\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Packages\Vietnamzone\Http\Requests\VietnamZoneRequest;
use Packages\Vietnamzone\Resources\VietnamZoneResource;
use Packages\Vietnamzone\Resources\VietnamZoneResourceCollection;
use Packages\Vietnamzone\Services\VietnamZoneService;
use Exception;
use Illuminate\Http\JsonResponse;

class VietnamZoneController extends Controller
{
    private $vietnamZoneService;

    /**
     * VietnamZoneController constructor.
     * @param VietnamZoneService $vietnamZoneService
     */
    public function __construct(
        VietnamZoneService $vietnamZoneService
    )
    {
        $this->vietnamZoneService = $vietnamZoneService;
    }

    /**
     * @param VietnamZoneRequest $request
     * @return JsonResponse
     */
    public function getProvince(VietnamZoneRequest $request): JsonResponse
    {
        try {
            $province = $this->vietnamZoneService->queryDataProvinces($request);
            return (new VietnamZoneResourceCollection($province))->response();

        } catch (Exception $exception) {
            return $this->responseExceptionV2($exception, 'getProvince');
        }
    }

    /**
     * @param VietnamZoneRequest $request
     * @return JsonResponse
     */
    public function getDistrict(VietnamZoneRequest $request): JsonResponse
    {
        try {
            $district = $this->vietnamZoneService->queryDataDistricts($request);
            return (new VietnamZoneResourceCollection($district))->response();

        } catch (Exception $exception) {
            return $this->responseExceptionV2($exception, 'getDistrict');
        }
    }

    /**
     * @param VietnamZoneRequest $request
     * @return JsonResponse
     */
    public function getWard(VietnamZoneRequest $request): JsonResponse
    {
        try {
            $ward = $this->vietnamZoneService->queryDataWards($request);
            return (new VietnamZoneResourceCollection($ward))->response();

        } catch (Exception $exception) {
            return $this->responseExceptionV2($exception, 'getWard');
        }
    }

    /**
     * @param VietnamZoneRequest $request
     * @return JsonResponse
     */
    public function addressByGso(VietnamZoneRequest $request): JsonResponse
    {
        try {
            $addresses = $this->vietnamZoneService->queryDataAddresses($request);
            return (new VietnamZoneResourceCollection($addresses))->response();

        } catch (Exception $exception) {
            return $this->responseExceptionV2($exception, 'addressByGso');
        }
    }

    /**
     * @param VietnamZoneRequest $request
     * @return JsonResponse
     */
    public function billingShippingFee(VietnamZoneRequest $request): JsonResponse
    {
        try {
            $rules = [
                'address_code' => ['required', 'string', 'min:1', 'max:5'],
            ];
            $validator = $this->validateRequest($request, $rules);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], VALIDATOR);
            }
            $shippingFees = $this->vietnamZoneService->handleShippingFee($request);
            return (new VietnamZoneResource($shippingFees))->response();

        } catch (Exception $exception) {
            return $this->responseExceptionV2($exception, 'billingShippingFee');
        }
    }

    /**
     * @param Exception $exception
     * @param string $function
     * @return JsonResponse
     */
    public function responseExceptionV2(Exception $exception, $function = ''): JsonResponse
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
                    'REQUEST' => \GuzzleHttp\json_encode(request()->except('_token')),
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
