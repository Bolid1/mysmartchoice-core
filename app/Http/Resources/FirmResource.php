<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Firm;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

/**
 * @property Firm $resource
 * @mixin Firm
 */
class FirmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'title'      => $this->title,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'users'      => $this->whenLoaded(
                'users',
                function ($default = null) {
                    $users = UserResource::collection($this->users);

                    $users::withoutWrapping();

                    return $users->count() ? $users : ($default ?? new MissingValue());
                }
            ),
        ];
    }
}
