<?php

namespace App\Http\Resources\V1\Gig;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @package App\Http\Resources\V1\Gig
 */
class CategoryResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {

        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'description' => $this['description'],
            'order'=> $this['order'],
            'ads' => $this->gigads->count()
        ];
    }

}
