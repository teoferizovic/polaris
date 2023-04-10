<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FeaturePermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
         return [
            'user_role' => $this->userRole->name,
            'feature_name' => $this->feature->name,
            'create_data' => (bool)$this->create_data,
            'read_data' => (bool)$this->read_data,
            'update_data' => (bool)$this->update_data,
            'delete_data' => (bool)$this->delete_data,
        ];
    }
}
