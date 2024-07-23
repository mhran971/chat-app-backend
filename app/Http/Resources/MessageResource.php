<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *

     */
    public function toArray($request){
        return [
        "id" => $this->id,
        "body" => $this->body,
        "read" => $this->read,
        "user_id" => $this->user_id,
        "conversation_id" => $this->conversation_id,
        "created_at" => $this->created_at,
            ];
	}
}
