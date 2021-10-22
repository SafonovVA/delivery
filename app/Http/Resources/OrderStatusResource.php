<?php

namespace App\Http\Resources;

use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        /** @var OrderStatus $this */
        return [
            'id' => $this->id,
            'name' => $this->name,
            'orders' => OrderResource::collection($this->whenLoaded('orders'))
        ];
    }
}
