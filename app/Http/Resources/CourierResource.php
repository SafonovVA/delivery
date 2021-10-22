<?php

namespace App\Http\Resources;

use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var Courier $this */
        return [
            'id' => $this->id,
            'credentials' => $this->credentials,
            'phone' => $this->phone,
            'orders' => OrderResource::collection($this->whenLoaded('orders'))
        ];
    }
}
