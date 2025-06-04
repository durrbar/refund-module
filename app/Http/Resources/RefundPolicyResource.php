<?php

namespace Modules\Refund\Http\Resources;

use Illuminate\Http\Request;
use Modules\Core\Http\Resources\Resource;
use Modules\Ecommerce\Http\Resources\RefundResource;
use Modules\Ecommerce\Http\Resources\ShopResource;

class RefundPolicyResource extends Resource
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
            'id'                   => $this->id,
            'title'                => $this->title,
            'slug'                 => $this->slug,
            'target'               => $this->target,
            'status'               => $this->status,
            'description'          => $this->description,
            'language'             => $this->language,
            'translated_languages' => $this->translated_languages,
            'shop'                 => new ShopResource($this->whenLoaded('shop')),
            'refunds'              => RefundResource::collection($this->whenLoaded('refunds')),
        ];
    }
}
