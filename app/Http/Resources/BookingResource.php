<?php

namespace App\Http\Resources;

use App\Enums\Booking\Status;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        dd($this->resource->stateHistory->toArray());
        return [
            'id' => $this->id,
            'starts_at' => $this->starts_at,
            'ends_at' => $this->ends_at,
            'status' => $this->status,
            'canceled_at' => $this->when($this->status()->was(Status::CANCELED), $this->status()->whenWas(Status::CANCELED)),
            'user' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
