<?php

namespace App\Domains\Shared\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class JsonErrorResponse extends JsonResponse
{
    /**
     * JsonErrorResponse constructor.
     *
     * @param  string  $errorMessage
     * @param  int  $status
     * @param  array|null  $headers
     * @param  array  $data
     */
    public function __construct(string $errorMessage, int $status = 400, ?array $headers = [], $data = [])
    {
        try {
            $time = LARAVEL_START;
        } catch (\Throwable $throwable) {
            $time = null;
        }
        $executionTime = !is_null($time) ? microtime(true) - $time : null;
        $memoryUsed = memory_get_usage();
        $data = [
            'success' => false,
            'data' => $data,
            'errors' => [
                [
                    'message' => $errorMessage
                ]
            ],
            'memoryUsed' => App::environment('testing') ? 0 : $this->convert($memoryUsed),
            'executionTime' => App::environment('testing') ? 0 : round($executionTime, 4),
        ];

        parent::__construct($data, $status, $headers);
    }

    private function convert($size): string
    {
        $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');

        return round($size / pow(1024, ($i = floor(log($size, 1024)))), 2).' '.$unit[$i];
    }
}
