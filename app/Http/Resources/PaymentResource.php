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
            'borrower' => [
                'id' => $this->borrower->id,
                'name' => $this->borrower->firstname . " " . $this->borrower->lastname,
                'avatar' => $this->borrower->avatar,
            ], 
            'amount' => $this->amount,
            'loan_id' => $this->loan_id,
            'status' => $this->status,
            'created_at' => $this->created_at->format('M-d-Y'),           
        ];
    }
}
