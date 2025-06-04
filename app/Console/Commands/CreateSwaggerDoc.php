<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use OpenApi\Generator;

class CreateSwaggerDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'swagger:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Генерирует документацию для Swagger';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controllers = $this->findPhpFiles(__DIR__."/../");
        $files = array_merge($controllers);

        $openapi = Generator::scan($files);

        $yaml = $openapi->toYaml();
        $json = $openapi->toJson();
        file_put_contents(__DIR__."/../../swagger/documentation.json", $json);
        echo $yaml;
    }

    private function findPhpFiles($directory)
    {
        $files = [];
        $items = scandir($directory);

        foreach ($items as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }

            $path = $directory.DIRECTORY_SEPARATOR.$item;

            if (is_dir($path)) {
                $files = array_merge($files, $this->findPhpFiles($path));
            } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
                $files[] = $path;
            }
        }

        return $files;
    }
}
