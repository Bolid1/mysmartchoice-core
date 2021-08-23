<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\OAuthClient;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property OAuthClient $resource
 * @mixin OAuthClient
 */
class OAuthClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request): array
    {
        return parent::toArray($request);
    }
}
