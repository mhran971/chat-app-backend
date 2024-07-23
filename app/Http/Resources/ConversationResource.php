<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return[
		"id" => $this->id,
		"user" => auth()->user()->id == $this->user_id ? new UserResource(User::find($this->seconde_user_id)) :  new UserResource(User::find($this->user_id)) ,
		"created_at" => $this->created_at,
		"messages" => MessageResource::collection($this->messages),
		];
    }
}
