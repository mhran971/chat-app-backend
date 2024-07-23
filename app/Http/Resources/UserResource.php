<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     */
    public function toArray($request)
    {
		$data['id']= $this->id;
		$data['name']= $this->name;
		$data['email']= $this->email;
		$data['image_url']= isset($this->picture)? $this->picture->full_path : null;
        return $data;
    }
}
