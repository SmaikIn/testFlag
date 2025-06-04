<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Attributes\Info;
use OpenApi\Attributes\SecurityScheme;
use OpenApi\Attributes\Server;

#[Info(
    version: '1.0',
    description: 'Документация для backend API',
    title: 'Документация для backend API'
)]
#[Server(
    url: 'http://localhost/api',
    description: 'Локальный API сервер',
)]
#[SecurityScheme(
    securityScheme: 'Bearer',
    type: 'http',
    description: 'JWT Bearer Token для аутентификации пользователей',
    bearerFormat: 'JWT',
    scheme: 'bearer'
)
]
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
