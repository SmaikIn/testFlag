<?php

namespace App\Domains\Shared\Responses\OpenApi\Errors;

use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;

/**
 * Класс ответа с ошибкой.
 *
 * @package common\openapi
 */
class OpenApiResponseNotFound extends Response
{
    /**
     * @param  int|string  $response
     * @param  string|null  $description
     */
    public function __construct(
        int|string $response = 404,
        ?string $description = 'Entity not found',
    ) {
        $properties = [
            new Property(property: 'success', type: 'boolean', default: false),
            new Property(property: 'errors', type: 'array', items: new Items(type: 'string')),
            new Property(property: 'executionTime', type: 'number', example: '1.9042'),
            new Property(property: 'memoryUsed', type: 'string', example: '28.22 mb'),
            new Property(property: 'data', type: 'object', additionalProperties: true),
        ];
        parent::__construct(
            response: $response,
            description: $description,
            content: new JsonContent(properties: $properties)
        );
    }
}
