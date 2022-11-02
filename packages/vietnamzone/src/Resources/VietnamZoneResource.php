<?php

namespace Packages\Vietnamzone\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VietnamZoneResource extends JsonResource
{
    public function __construct($resource)
    {
        if (is_object($resource)) $resource = (array) $resource;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param $request
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
