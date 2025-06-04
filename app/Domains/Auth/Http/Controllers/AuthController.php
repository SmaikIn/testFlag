<?php

declare(strict_types=1);

namespace App\Domains\Auth\Http\Controllers;

use App\Domains\Auth\Dto\AuthAttemptDto;
use App\Domains\Auth\Http\Requests\LoginByEmailRequest;
use App\Domains\Auth\Http\Resources\TokenResource;
use App\Domains\Auth\Services\AuthService;
use App\Domains\Shared\Responses\JsonApiResponse;
use App\Domains\Shared\Responses\JsonErrorResponse;
use App\Domains\Shared\Responses\OpenApi\OpenApiResponseError;
use App\Domains\Shared\Responses\OpenApi\OpenApiResponseItem;
use App\Domains\User\ValueObject\Email;
use App\Domains\User\ValueObject\Password;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use InvalidArgumentException;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    public function __construct(
        private readonly AuthService $authService,
    ) {
    }


    #[Post(
        path: '/auth/login',
        description: 'Аутентификация пользователя по электронной почте и паролю',
        summary: 'Аутентификация пользователя',
        tags: ['Авторизация'],
        parameters: [
            new Parameter(
                name: 'email',
                description: 'Электронная почта пользователя',
                in: 'query',
                required: true,
                example: 'user@example.com',
            ),
            new Parameter(
                name: 'password',
                description: 'Пароль пользователя',
                in: 'query',
                required: true,
                example: 'password123',
            ),
        ],
        responses: [
            new OpenApiResponseItem(
                description: 'Успешный ответ с токеном аутентификации',
                ref: '#/components/schemas/TokenResource'
            ),
            new OpenApiResponseError(400, 'These credentials do not match our records'),
            new OpenApiResponseError(),
        ]
    )]
    public function loginByEmail(LoginByEmailRequest $request): JsonApiResponse|JsonErrorResponse
    {
        try {
            $dto = new AuthAttemptDto(
                Email::create($request->get('email')),
                Password::create($request->get('password'))
            );
        } catch (InvalidArgumentException $exception) {
            return new JsonErrorResponse($exception->getMessage(), status: Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $token = $this->authService->attempt($dto);

        if (is_null($token)) {
            return new JsonErrorResponse(__('auth.failed'));
        }

        return new JsonApiResponse((TokenResource::make($token))->toArray($request));
    }

    #[Post(
        path: '/auth/refresh',
        description: 'Обновляет токен аутентификации пользователя',
        summary: 'Обновление токена',
        tags: ['Авторизация'],
        responses: [
            new OpenApiResponseItem(
                response: 200,
                description: 'Успешный ответ с обновленным токеном аутентификации и данными пользователя',
                ref: '#/components/schemas/TokenResource',
            ),
            new OpenApiResponseError(
                response: 401,
                description: 'Ошибка обновления токена',
            ),
            new OpenApiResponseError(),
        ]
    )]
    public function refresh(Request $request)
    {
        $token = $this->authService->refresh();

        if (is_null($token)) {
            return new JsonErrorResponse(__('auth.refresh'));
        }

        return new JsonApiResponse((TokenResource::make($token))->toArray($request));
    }

    #[Post(
        path: '/auth/logout',
        description: 'Выход пользователя из системы',
        summary: 'Выход из аккаунта',
        security: [['Bearer' => []]],
        tags: ['Авторизация'],
        responses: [
            new OpenApiResponseItem(
                response: 204,
                description: 'Успешный выход из системы',
            ),
            new OpenApiResponseError(),
        ]
    )]
    public function logout(): JsonErrorResponse|JsonApiResponse
    {
        $this->authService->logout();

        return new JsonApiResponse([], status: 204);
    }


}
