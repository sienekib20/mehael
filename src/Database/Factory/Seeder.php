<?php

namespace Sienekib\Mehael\Database\Factory;

class Seeder
{
    public function call(array $seeders)
    {
        foreach ($seeders as $seeder) {
            if (!class_exists($seeder)) {
                echo 'Seeder namespace inválido';
                exit;
            }
            echo "\033[0;32mSeeding: $seeder\033[0m" . PHP_EOL;
            (new $seeder())->run();
            sleep(0.8);
            echo "\033[0;33mSeeded: $seeder  (" . date('m:s') . "ms)\033[0m" . PHP_EOL;
        }
    }
}
