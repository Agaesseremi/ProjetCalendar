<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        // return parent::toArray($request);
        // On retourne uniquement "first_name" "last_name "et "email"
        return [
            "first_name" => ucfirst($this->first_name), // La 1er lettre en majuscule
            "last_name" => ucfirst($this->last_name),
            "email" => $this->email
        ];
    }
}
