<?php

namespace App\Console\Commands;

use Dedoc\Scramble\Generator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Console\Command\Command as CommandAlias;

class GenerateSwaggerCommand extends Command
{

    protected $signature = 'openapi:generate';

    protected $description = 'Доп.команда для генерации документации сваггер с сохранением в файл';

    /**
     * @param Generator $generator
     * @return int
     */
    public function handle(Generator $generator): int
    {
        try {
            Storage::set(json_encode($generator()), config('scramble.openapi_disk'));
            Storage::disk(config('scramble.openapi_disk'))->put(
                config('scramble.json_path'),
                json_encode($generator())
            );
            $this->info('Successfully processed!');

            return CommandAlias::SUCCESS;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());

            return CommandAlias::FAILURE;
        }
    }
}
