<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,        
            'phone' => $this->phone,
            'avatar' => $this->avatar,
            'address' => $this->address,
            'role' => $this->role ==  2 ? 'Employee' : 'Admin' ,
            'created_at' => $this->created_at->toFormattedDateString(),
        ];
    }
}
