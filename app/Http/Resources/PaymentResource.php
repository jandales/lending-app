<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->firstname . " " . $this->customer->lastname,
                'avatar' => $this->customer->avatar,
            ], 
            'amount' => $this->amount,
            'loan_id' => $this->loan_id,
            'status' => $this->status,
            'created_at' => $this->created_at->format('M-d-Y'),           
        ];
    }
}
