<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WebsiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->url,
            'user_id' => $this->user_id,
            'privacy' => $this->privacy,
            'email' => $this->email,
            'password' => $this->password,
            'exclude_bots' => $this->exclude_bots,
            'exclude_ips' => $this->exclude_ips,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function with($request)
    {
        return [
            'status' => 200
        ];
    }
}
