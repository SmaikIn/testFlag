<?php

namespace App\Domains\Shared\Responses\OpenApi;

use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;

/**
 * Класс ответа с ошибкой.
 *
 * @package common\openapi
 */
class OpenApiResponseItem extends Response
{
    /**
     * @param  int|string  $response
     * @param  string|null  $description
     * @param  string|null  $ref
     */
    public function __construct(
        int|string $response = 200,
        ?string $description = 'messages.returns_an_entity_by_its_id',
        ?string $ref = '',
    ) {
        $properties = [
            new Property(property: 'success', type: 'boolean', example: true),
            new Property(property: 'errors', type: 'array', items: new Items(type: 'string')),
            new Property(property: 'executionTime', type: 'number', example: '1.9042'),
            new Property(property: 'memoryUsed', type: 'string', example: '28.22 mb'),
            new Property(property: 'data', ref: $ref, type: 'object'),
        ];
        parent::__construct(
            response: $response,
            description: $description,
            content: new JsonContent(properties: $properties)
        );
    }
}
