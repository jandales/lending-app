<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Http\Resources\PaymentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $payments = $this->whenLoaded('payments');
        return [
            
            'id' => $this->id,                     
            'principal_amount' => $this->principal_amount,
            'total_amount' => $this->total_amount,
            'balance_amount' => $this->balance_amount,
            'interest' => $this->interest,
            'status' => $this->status,
            'effective_at' => Carbon::parse($this->effective_at)->format('M-d-Y'),
            'created_at' => $this->created_at->format('M-d-Y'), 
            'customer' => [
                'id' => $this->customer->id,
                'name' => $this->customer->firstname . " " . $this->customer->lastname,
                'avatar' => $this->customer->avatar,
            ], 
            'loan_type' => [
                'id' => $this->loantype->id,
                'type' => $this->loantype->type,
                'interest' =>$this->loantype->interest,
                'amount_to_pay' => $this->loantype->amount_to_pay,
            ], 
            'payments' => PaymentResource::collection($payments)
        ];
    }
}
