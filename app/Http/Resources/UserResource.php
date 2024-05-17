<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    //     public function toArray(Request $request): array
    //    {
    //         return parent::toArray($request);
    //     }
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'mobile_number' => $this->mobile_number,
            'email' => $this->email,
            // 'email_verified_at' => $this->email_verified_at,
            // 'is_admin' => $this->is_admin,
        ];
    }
}
