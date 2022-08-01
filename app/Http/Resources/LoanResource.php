<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\BorrowerResource;
use App\Http\Resources\LoanTypeResource;
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
       
        return [            
            'id' => $this->id,   
            'loan_number' => $this->loan_number,                  
            'terms' => $this->terms,
            'principal_amount' => $this->principal_amount,
            'total_amount' => $this->total_amount,
            'balance_amount' => $this->balance_amount,
            'total_interest' => $this->total_interest,
            'collection_amount' => $this->collection_amount,
            'interest' => $this->interest,
            'status' => $this->status,
            'effective_at' => Carbon::parse($this->effective_at)->format('M-d-Y'),
            'created_at' => $this->created_at->format('M-d-Y'), 
            'borrower' => BorrowerResource::make($this->whenLoaded('borrower')),                  
            'payments' => PaymentResource::collection($this->whenLoaded('payments')),
            'due_dates' => DueDateResource::collection($this->whenLoaded('dueDates')),
        ];
    }
}
