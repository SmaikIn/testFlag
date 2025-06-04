<?php

namespace App\Domains\Shared\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class JsonApiResponse extends JsonResponse
{
    /**
     * JsonAPIResponse constructor.
     *
     * @param  array  $data
     * @param  array  $errors
     * @param  int  $status
     * @param  array|null  $headers
     */
    public function __construct(array $data, array $errors = [], int $status = 200, ?array $headers = [])
    {
        try {
            $time = LARAVEL_START;
        } catch (\Throwable $throwable) {
            $time = null;
        }
        $executionTime = !is_null($time) ? microtime(true) - $time : null;
        $memoryUsed = memory_get_usage();

        $data = [
            'success' => !count($errors) && $status !== Response::HTTP_NOT_FOUND,
            'data' => $data,
            'errors' => $errors,
            'memoryUsed' => App::environment('testing') ? 0 : $this->convert($memoryUsed),
            'executionTime' => App::environment('testing') ? 0 : round($executionTime, 4),
        ];

        parent::__construct($data, $status, $headers);
    }

    private function convert($size): string
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');

        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$unit[$i];
    }
}
