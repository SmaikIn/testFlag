<?php

declare(strict_types=1);

namespace App\Domains\User\Http\Controllers;

use App\Domains\Shared\Responses\OpenApi\Errors\OpenApiResponseNotFound;
use App\Domains\Shared\Responses\OpenApi\Errors\OpenApiResponseUnauthorized;
use App\Domains\Shared\Responses\OpenApi\Errors\OpenApiResponseValidateError;
use App\Domains\Shared\Responses\OpenApi\OpenApiResponseError;
use App\Domains\User\Dto\UserDto;
use App\Domains\User\Http\Requests\UserCreateRequest;
use App\Domains\User\Http\Requests\UserDeleteRequest;
use App\Domains\User\Http\Requests\UserUpdateRequest;
use App\Domains\User\Http\Resources\UserResource;
use App\Domains\User\Service\UserService;
use App\Domains\User\ValueObject\Email;
use App\Domains\User\ValueObject\Password;
use App\Http\Controllers\Controller;
use App\Domains\Shared\Responses\JsonApiResponse;
use App\Domains\Shared\Responses\JsonErrorResponse;
use App\Domains\Shared\Responses\OpenApi\OpenApiResponseItem;
use Illuminate\Support\Carbon;
use InvalidArgumentException;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Put;
use Symfony\Component\HttpFoundation\Response as CodeResponse;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {
    }

    #[Post(
        path: '/users',
        description: 'Создание нового пользователя',
        summary: 'Создание пользователя',
        tags: ['Пользователи'],
        parameters: [
            new Parameter(
                name: 'name',
                description: 'Имя пользователя',
                in: 'query',
                required: true,
                example: 'Иван Иванов'
            ),
            new Parameter(
                name: 'email',
                description: 'Email пользователя',
                in: 'query',
                required: true,
                example: 'user@example.com'
            ),
            new Parameter(
                name: 'password',
                description: 'Пароль пользователя (мин. 8 символов)',
                in: 'query',
                required: true,
                example: 'securePassword123'
            )
        ],
        responses: [
            new OpenApiResponseItem(
                response: 201,
                description: 'Успешное создание пользователя',
                ref: '#/components/schemas/UserResource'
            ),
            new OpenApiResponseValidateError(),
            new OpenApiResponseError(),
        ]
    )]
    /**
     * Создание нового пользователя
     */
    public function create(UserCreateRequest $request): JsonApiResponse|JsonErrorResponse
    {
        try {
            $userDto = new UserDto(
                id: null,
                name: $request->input('name'),
                email: Email::create($request->input('email')),
                password: Password::create($request->input('password')),
                createdAt: null,
                updatedAt: null
            );
        } catch (InvalidArgumentException $exception) {
            return new JsonErrorResponse($exception->getMessage(), status: CodeResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->userService->create($userDto);

        return new JsonApiResponse(UserResource::make($user)->toArray($request), status: CodeResponse::HTTP_CREATED);
    }

    #[Put(
        path: '/users/{userId}',
        description: 'Обновление данных пользователя',
        summary: 'Обновление пользователя',
        security: [['Bearer' => []]],
        tags: ['Пользователи'],
        parameters: [
            new Parameter(
                name: 'userId',
                description: 'ID пользователя',
                in: 'path',
                required: true,
                example: 1
            ),
            new Parameter(
                name: 'name',
                description: 'Имя пользователя',
                in: 'query',
                required: false,
                example: 'Иван Иванов'
            ),
            new Parameter(
                name: 'email',
                description: 'Email пользователя',
                in: 'query',
                required: false,
                example: 'new.email@example.com'
            ),
            new Parameter(
                name: 'password',
                description: 'Новый пароль пользователя (мин. 8 символов)',
                in: 'query',
                required: false,
                example: 'newSecurePassword123'
            )
        ],
        responses: [
            new OpenApiResponseItem(
                description: 'Успешное обновление пользователя',
                ref: '#/components/schemas/UserResource'
            ),
            new OpenApiResponseValidateError(),
            new OpenApiResponseNotFound(),
            new OpenApiResponseUnauthorized(),
            new OpenApiResponseError(),
        ]
    )]
    /**
     * Обновление существующего пользователя
     */
    public function update(UserUpdateRequest $request): JsonApiResponse
    {
        $userDto = new UserDto(
            id: $request->input('userId'),
            name: $request->input('name'),
            email: Email::create($request->input('email')),
            password: null,
            createdAt: null,
            updatedAt: Carbon::now()
        );

        $this->userService->update($userDto);

        return new JsonApiResponse([], status: CodeResponse::HTTP_OK);
    }

    #[Delete(
        path: '/users/{userId}',
        description: 'Удаление пользователя',
        summary: 'Удаление пользователя',
        security: [['Bearer' => []]],
        tags: ['Пользователи'],
        parameters: [
            new Parameter(
                name: 'userId',
                description: 'ID пользователя',
                in: 'path',
                required: true,
                example: 1
            )
        ],
        responses: [
            new OpenApiResponseItem(
                response: 204,
                description: 'Успешное удаление пользователя',
            ),
            new OpenApiResponseNotFound(),
            new OpenApiResponseUnauthorized(),
            new OpenApiResponseError(),
        ]
    )]
    /**
     * Удаление пользователя
     */
    public function delete(UserDeleteRequest $request): JsonApiResponse
    {
        $userId = $request->input('userId');

        $this->userService->delete($userId);

        return new JsonApiResponse([], status: CodeResponse::HTTP_NO_CONTENT);
    }
}
