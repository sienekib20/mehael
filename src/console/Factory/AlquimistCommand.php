<?php

namespace Sienekib\Mehael\Console;

class AlquimistCommand
{

}


/*
class AlquimistCommand
{
    public function run($argv)
    {
        if (count($argv) < 4) {
            echo "Usage: php alquimist make:controller --dir=<dir> --resources\n";
            exit(1);
        }

        $options = $this->parseOptions($argv);

        if ($options['command'] === 'make:controller') {
            $this->makeController($options);
        } else {
            echo "Unknown command: {$options['command']}\n";
            exit(1);
        }
    }

    private function parseOptions($argv)
    {
        $options = [
            'command' => $argv[1],
            'dir' => null,
            'resources' => false,
        ];

        foreach ($argv as $index => $arg) {
            if ($arg === '--dir' && isset($argv[$index + 1])) {
                $options['dir'] = $argv[$index + 1];
            }

            if ($arg === '--resources') {
                $options['resources'] = true;
            }
        }

        return $options;
    }

    private function makeController($options)
    {
        $dir = $options['dir'] ?? '';
        $resources = $options['resources'] ? ' with resources' : '';

        echo "Creating controller in directory '{$dir}'{$resources}\n";
        // Lógica para criar o controlador vai aqui
    }
}

$alquimistCommand = new AlquimistCommand();
$alquimistCommand->run($argv);


 private function runServe()
    {
        echo "Starting server on http://127.0.0.1:8000\n";
        exec("php -S 127.0.0.1:8000 -t public");
    }