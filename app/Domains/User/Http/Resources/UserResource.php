<?php

namespace App\Domains\User\Http\Resources;

use App\Domains\User\Dto\UserDto;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Schema;

#[Schema(
    schema: 'UserResource',
    description: 'Объект UserResource',
    properties: [
        new Property(property: 'id', description: 'Идентификатор пользователя', type: 'integer'),
        new Property(property: 'firstName', description: 'Имя пользователя', type: 'string'),
        new Property(property: 'email', description: 'Электронная почта пользователя', type: 'string'),
        new Property(property: 'createdAt', description: 'Дата и время создания записи', type: 'string'),
        new Property(property: 'createdAt', description: 'Дата и время последнего обновления записи', type: 'string'),
    ],
    type: 'object'
)]
/**
 * @property UserDto $resource
 */
class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->resource->getId(),
            'firstName' => $this->resource->getName(),
            'email' => $this->resource->getEmail()->getValue(),
            'createdAt' => $this->resource->getCreatedAt()->toIso8601String(),
            'updatedAt' => $this->resource->getUpdatedAt()->toIso8601String(),
        ];
    }
}
