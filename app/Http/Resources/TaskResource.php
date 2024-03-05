<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status,
            'category' => [
                'id' => $this->category->id,
                'name' => $this->category->name
            ],
            'createdAt' => $this->created_at->format('Y-m-d H:m:i')
        ];
    }
}
