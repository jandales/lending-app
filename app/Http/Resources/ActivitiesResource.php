<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivitiesResource extends JsonResource
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
            'action' => $this->action,   
            'remark' => $this->remark,  
            'created_at' => $this->created_at->toFormattedDateString(),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
