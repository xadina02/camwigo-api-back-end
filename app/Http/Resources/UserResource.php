<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected $token;
    protected $tokenType;

    /**
     * Create a new resource instance.
     *
     * @param  mixed  $resource
     * @param  string  $token
     * @param  string  $tokenType
     * @return void
     */
    public function __construct($resource, $token = NULL, $tokenType = NULL)
    {
        parent::__construct($resource);
        $this->token = $token;
        $this->tokenType = $tokenType;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $request['tokenType'] = $this->tokenType;
        $request['accessToken'] = $this->token;

        return [
            'data' => [
                'tokenType' => $this->tokenType,
                'accessToken' => $this->token,
                'attributes' => [
                    'user_id' => $this->id,
                    'first_name' => $this->first_name,
                    'last_name' => $this->last_name,
                    'NIN' => $this->NIN,
                    'phone' => $this->phone,
                    'email' => $this->email,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at,
                ],
                'relationships' => [
                    'reservations' => ReservationResource::collection($this->whenLoaded('reservations')),
                ]
            ]
        ];
    }
}
