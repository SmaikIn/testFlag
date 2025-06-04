<?php

namespace App\Domains\Auth\Http\Resources;

use App\Domains\Auth\Dto\JWTDto;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    schema: 'TokenResource',
    description: 'Объект TokenResource',
    properties: [
        new Property(property: 'accessToken', type: 'string'),
        new Property(property: 'tokenType', type: 'string'),
        new Property(property: 'expires', description: 'Дата истечения срока действия токена в формате ISO 8601',
            type: 'string'),
    ],
    type: 'object'
)]
/**
 * @property JWTDto $resource
 */
class TokenResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'accessToken' => $this->resource->getToken(),
            'tokenType' => $this->resource->getType(),
            'expires' => $this->resource->getPayload()->getExpires()->toIso8601String(),
        ];
    }
}
