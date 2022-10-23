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
            'amount' => $this->amount,            
            'status' => $this->status,
            'created_at' => $this->created_at->toFormattedDateString(),
            'borrower' => [
                'id' => $this->borrower->id,
                'name' => $this->borrower->firstname . " " . $this->borrower->lastname,
                'avatar' => $this->borrower->avatar,
            ], 
            'loan'=> [
                'id' => $this->loan->id,
                'number' => $this->loan->loan_number,
                'status' => $this->status,
            ]           
        ];
    }
}
