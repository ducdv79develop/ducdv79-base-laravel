<?php

namespace Packages\Vietnamzone\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class VietnamZoneResourceCollection extends ResourceCollection
{
    public function __construct($resource)
    {
        $resource = $resource->map(function ($item) {
            return (is_object($item)) ? (array) $item : $item;
        });
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param  $request
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
