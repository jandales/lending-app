<?php

namespace App\Http\Resources;

use App\Http\Resources\ActivitiesResource;
use Illuminate\Http\Resources\Json\JsonResource;

class FundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'initial_capital' => $this->initial_capital,
            'current_capital' => $this->current_capital,
            'activities' => ActivitiesResource::collection($this->whenLoaded('activities')),
        ];
    }
}
