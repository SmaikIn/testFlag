<?php

declare(strict_types=1);

namespace App\Domains\User\Service;

use App\Domains\User\Dto\UserDto;
use App\Domains\User\Repositories\Database\UserRepository;
use App\Domains\Shared\Exceptions\DatabaseException;
use App\Domains\Shared\Exceptions\NotFoundException;
use App\Domains\Shared\Exceptions\ServiceException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final readonly class UserService
{
    public function __construct(
        private UserRepository $userRepository,
    ) {
    }


    public function create(UserDto $userDto): ?UserDto
    {
        try {
            return $this->userRepository->create($userDto);
        } catch (QueryException $e) {
            throw new DatabaseException(previous: $e);
        } catch (Throwable $e) {
            throw new ServiceException($e->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR, previous: $e);
        }
    }

    public function update(UserDto $dto): UserDto
    {
        try {
            return $this->userRepository->update($dto);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User", previous: $e);
        } catch (QueryException $e) {
            throw new DatabaseException(previous: $e);
        } catch (Throwable $e) {
            throw new ServiceException($e->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR, previous: $e);
        }
    }

    public function delete(int $uuid): bool
    {
        try {
            return $this->userRepository->deleteById($uuid);
        } catch (ModelNotFoundException $e) {
            throw new NotFoundException("User", previous: $e);
        } catch (QueryException $e) {
            throw new DatabaseException(previous: $e);
        } catch (Throwable $e) {
            throw new ServiceException($e->getMessage(), code: Response::HTTP_INTERNAL_SERVER_ERROR, previous: $e);
        }
    }
}