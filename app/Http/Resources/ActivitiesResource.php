<?php

namespace App\Http\Resources;

use App\Helpers\FundActivityLabel;
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
        $signedAmount = $this->action === 'deposit'
            ? (float) $this->amount
            : -(float) $this->amount;

        return [
            'id' => $this->id,
            'action' => $this->action,
            'action_label' => FundActivityLabel::from($this->action, $this->remark),
            'remark' => $this->remark,
            'last_capital_amount' => $this->last_capital_amount,
            'amount' => $this->amount,
            'running_balance' => (float) $this->last_capital_amount + $signedAmount,
            'created_at' => $this->created_at->toFormattedDateString(),
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
