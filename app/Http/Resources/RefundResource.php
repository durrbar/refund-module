<?php

namespace Modules\Refund\Http\Resources;

use Illuminate\Http\Request;
use Modules\Core\Http\Resources\Resource;

class RefundResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'refund_reason' => $this->whenLoaded('refund_reason', fn () => ['name' => $this->refund_reason?->name], ['name' => null]),
            'amount' => $this->amount,
            'status' => $this->status,
            'customer' => $this->whenLoaded('customer', fn () => ['email' => $this->customer?->email], ['email' => null]),
            'order' => $this->whenLoaded('order', fn () => $this->getOrderData($this->order)),
            'created_at' => $this->created_at,
        ];
    }

    private function getOrderData($data): ?array
    {
        if (! $data) {
            return null;
        }

        return [
            'id' => $data->id,
            'tracking_number' => $data->tracking_number,
            'created_at' => $this->created_at,
        ];
    }
}
