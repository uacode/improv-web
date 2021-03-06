<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\V1\Image\HeaderImageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{

    protected function getMembers(): \Traversable
    {

        foreach ($this->users as $user) {
            yield [
                'username' => $user->username,
                'role' => $user->pivot->role,
            ];
        }
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'name' => $this->name,
            'uid' => $this->uid,
            'description' => $this->description,
            'is_public' => $this->is_public,
            'email' => $this->email,
            'urls' => [
                'facebook' => $this->facebook_url,
                'homepage' => $this->homepage_url
            ],
            'is_member' => $this->when($request->user(), $this->isMember($request->user())),
            'members' => iterator_to_array($this->getMembers()),
            'images' => new HeaderImageResource($this)
        ];
    }
}
