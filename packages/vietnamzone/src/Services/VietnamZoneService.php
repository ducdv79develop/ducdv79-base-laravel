<?php

namespace Packages\Vietnamzone\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Modules\Product\Helpers\ProductHelpers;

class VietnamZoneService
{
    private $provinces;
    private $districts;
    private $wards;
    private $name;
    private $province_id;
    private $district_id;
    private $code;

    /**
     * VietnamZoneService constructor.
     */
    public function __construct()
    {
        $this->provinces = config('Vietnamzone::config.tables.provinces');
        $this->districts = config('Vietnamzone::config.tables.districts');
        $this->wards = config('Vietnamzone::config.tables.wards');
        $this->name = config('Vietnamzone::config.columns.name');
        $this->province_id = config('Vietnamzone::config.columns.province_id');
        $this->district_id = config('Vietnamzone::config.columns.district_id');
        $this->code = config('Vietnamzone::config.columns.address_code');
    }

    /**
     * @param Request|array $request
     * @return Collection
     */
    public function queryDataProvinces($request): Collection
    {
        $request = ($request instanceof Request) ? $request->all() : $request;
        $province = DB::table($this->provinces)
            ->select([
                "$this->provinces.id AS province_id",
                "$this->provinces.$this->name AS province_name",
                "$this->provinces.$this->name AS name",
                "$this->provinces.$this->code AS code",
            ])
            ->orderBy("$this->provinces." . ($request['sort'] ?? 'name'), $request['direction'] ?? 'asc');

        if (isset($request['province_id'])) {
            $province = $province->where("$this->provinces.id", $request['province_id']);
        }

        if (isset($request['search'])) {
            $province = $province->where("$this->provinces.$this->name", 'LIKE', '%' . escapeLike($request['search']) . '%');
        }

        if (isset($request['address_code'])) {
            $province = $province->where("$this->provinces.$this->code", 'LIKE', '%' . escapeLike($request['address_code']) . '%');
        }

        return $province->get();
    }

    /**
     * @param Request|array $request
     * @return Collection
     */
    public function queryDataDistricts($request): Collection
    {
        $request = ($request instanceof Request) ? $request->all() : $request;
        $district = DB::table($this->provinces)
            ->join($this->districts, "$this->districts.$this->province_id", "=", "$this->provinces.id")
            ->select([
                "$this->districts.id AS district_id",
                "$this->districts.$this->name AS district_name",
                "$this->districts.$this->province_id AS province_id",
                "$this->provinces.$this->name AS province_name",
                DB::raw("CONCAT($this->districts.$this->name,', ',$this->provinces.$this->name) AS name"),
                "$this->districts.$this->code AS code",
            ])
            ->orderBy("$this->districts." . ($request['sort'] ?? 'name'), $request['direction'] ?? 'asc');

        if (isset($request['province_id'])) {
            $district = $district->where("$this->districts.$this->province_id", $request['province_id']);
        }

        if (isset($request['district_id'])) {
            $district = $district->where("$this->districts.id", $request['district_id']);
        }

        if (isset($request['search'])) {
            $district = $district->where(function ($q) use ($request) {
                $q->where("$this->districts.$this->name", 'LIKE', '%' . escapeLike($request['search']) . '%')
                    ->orWhere("$this->provinces.$this->name", 'LIKE', '%' . escapeLike($request['search']) . '%');
            });
        }

        if (isset($request['address_code'])) {
            $district = $district->where("$this->districts.$this->code", 'LIKE', '%' . escapeLike($request['address_code']) . '%');
        }

        return $district->get();
    }

    /**
     * @param Request|array $request
     * @return Collection
     */
    public function queryDataWards($request): Collection
    {
        $request = ($request instanceof Request) ? $request->all() : $request;
        $ward = DB::table($this->provinces)
            ->join($this->districts, "$this->districts.$this->province_id", "=", "$this->provinces.id")
            ->join($this->wards, "$this->wards.$this->district_id", "=", "$this->districts.id")
            ->select([
                "$this->wards.id AS ward_id",
                "$this->wards.$this->name AS ward_name",
                "$this->wards.$this->district_id AS district_id",
                "$this->districts.$this->name AS district_name",
                "$this->districts.$this->province_id AS province_id",
                "$this->provinces.$this->name AS province_name",
                DB::raw("CONCAT($this->wards.$this->name,', ',$this->districts.$this->name,', ',$this->provinces.$this->name) AS name"),
                "$this->wards.$this->code AS code",
            ])
            ->orderBy("$this->wards." . ($request['sort'] ?? 'name'), $request['direction'] ?? 'asc');

        if (isset($request['province_id'])) {
            $ward = $ward->where("$this->districts.$this->province_id", $request['province_id']);
        }

        if (isset($request['district_id'])) {
            $ward = $ward->where("$this->wards.$this->district_id", $request['district_id']);
        }

        if (isset($request['ward_id'])) {
            $ward = $ward->where("$this->wards.id", $request['ward_id']);
        }

        if (isset($request['search'])) {
            $ward = $ward->where(function ($q) use ($request) {
                $q->where("$this->wards.$this->name", 'LIKE', '%' . escapeLike($request['search']) . '%')
                    ->orWhere("$this->districts.$this->name", 'LIKE', '%' . escapeLike($request['search']) . '%')
                    ->orWhere("$this->provinces.$this->name", 'LIKE', '%' . escapeLike($request['search']) . '%');
            });
        }

        if (isset($request['address_code'])) {
            $ward = $ward->where("$this->wards.$this->code", 'LIKE', '%' . escapeLike($request['address_code']) . '%');
        }

        return $ward->get();
    }

    /**
     * @param Request|array $request
     * @return Collection
     */
    public function queryDataAddresses($request): Collection
    {
        $request = ($request instanceof Request) ? $request->all() : $request;
        $code = isset($request['address_code']) ? $request['address_code'] : null;

        if (empty($code)) return $this->queryDataWards($request);

        if (strlen($code) <= 2) return $this->queryDataProvinces($request);

        if (strlen($code) <= 3) return $this->queryDataDistricts($request);

        return $this->queryDataWards($request);
    }

    /**
     * @param Request|array $request
     * @return array
     * @throws Exception
     */
    public function handleShippingFee($request): array
    {
        $data = $this->queryDataAddresses($request);
        if (empty($data) || $data->isEmpty()) {
            throw (new Exception(__('validation.exists', ['attribute' => 'address_code']), UNPROCESSABLE_ENTITY));
        }
        $data = $data->first();
        $settingProvinceID = config('Vietnamzone::config.shipping_fee.province_id');

        // default value
        $shippingFee = config('Vietnamzone::config.shipping_fee.default');
        $message = config('Vietnamzone::config.shipping_fee.message');

        if (isset($data->province_id) && key_exists($data->province_id, $settingProvinceID)) {
            $shippingFee = $settingProvinceID[$data->province_id];
            $status = true;
        } else {
            $message = config('Vietnamzone::config.shipping_fee.message_error');
            $status = false;
        }
        $priceFormat = number_format($shippingFee, 0, ',', '.') . '₫';

        return [
            'address_code' => $data->code,
            'name' => $data->name,
            'shipping_fee' => $shippingFee,
            'shipping_fee_str' => $priceFormat,
            'message' => $message,
            'status' => $status
        ];
    }
}
