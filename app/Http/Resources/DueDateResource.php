<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class DueDateResource extends JsonResource
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
            'loan_id' => $this->loan_id,
            'amount_paid' => $this->amount_paid,
            'balance' => $this->balance,
            'collection_amount' => $this->collection_amount,
            'due_date' => Carbon::parse($this->due_date)->format('Y-m-d'),
            'paid_at' =>  $this->paid_at != null ?  Carbon::parse($this->paid_at)->format('Y-m-d') : null,
            'status' => $this->status,
        ];
    }
}
