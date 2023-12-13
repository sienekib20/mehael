<?php

namespace Sienekib\Mehael\Console\Factory;

use Database\Factory\DatabaseSeeders;
use Sienekib\Mehael\Console\Printer;
use Sienekib\Mehael\Database\Factory\Schema;

class AlquimistCommand
{
    // the printer object
    private Printer $printer;
    private string $app = 'app/';
    private string $database = 'database/migrations';
    private string $seeder = 'database/seeders';

    public function __construct()
    {
        $this->printer = new Printer();
    }

    public function run($argv)
    {
        if (count($argv) < 2)
            $this->printer->withError('Usage: php alquimist [command]')->exit();

        $command = $argv[1];
        unset($argv[1]);

        switch ($command) {
            case 'run:server':
                $this->runServer();
                break;
            case 'storage:link':
                $this->storage(true);
                break;
            case 'make:class':
                if (!isset($argv[2]))
                    $this->printer->withError('Usage: php alquimist make:class <name>')->exit();
                $this->make_class($argv[2]);
                break;
            case 'make:controller':
                if (!isset($argv[2]))
                    $this->printer->withError('Usage: php alquimist make:controller <name>')->exit();
                $this->make_controller($argv[2]);
                break;
            case 'make:migration':
                if (!isset($argv[2]))
                    $this->printer->withError('Usage: php alquimist make:migration <name>')->exit();
                $this->make_migration($argv[2]);
                break;
            case 'make:seeder':
                if (!isset($argv[2]))
                    $this->printer->withError('Usage: php alquimist make:seeder <name>')->exit();
                $this->make_seeder($argv[2]);
                break;
            case 'make:model':
                if (!isset($argv[2]))
                    $this->printer->withError('Usage: php alquimist make:model <name>')->exit();
                $this->make_model($argv[2]);
                break;
            case 'migrate:fresh':
                $this->migrate();
                break;
            default:
                $this->printer->withError("Unknown command: {$command}")->exit();
        }
    }

    private function buildStorageCommand(string $target, string $user)
    {
        $sistemaOperacional = PHP_OS;

        switch (true) {
            case stripos($sistemaOperacional, 'WIN') !== false:
                return "cacls $target /E /G $user:R";
            case stripos($sistemaOperacional, 'Linux') !== false:
            case stripos($sistemaOperacional, 'Darwin') !== false:
                return "chmod -R 755 $target";
            default:
                return null; // Sistema operacional não reconhecido
        }
    }

    private function storage($link = true)
    {
        $user = get_current_user();
        $target = abs_path() . '/public/';
        $link = abs_path() . '/storage/';

        $v = @link('public/', 'storage/leiame.txt');

        var_dump($v);
        exit;
    }

    private function make_class(string $name)
    {
        $path = $this->app . 'Http/Controllers';
        $this->make('class', $path, $name);
    }

    private function make_controller(string $name)
    {
        $path = $this->app . 'Http/Controllers';
        $this->make('controller', $path, $name);
    }

    private function make(string $sample_name, string $target, string $name)
    {
        $sample_path = str_replace('/', DIRECTORY_SEPARATOR, 'src/Factory/Samples/');
        $path = str_replace('/', DIRECTORY_SEPARATOR, $target);

        if (!is_dir($path)) {
            $this->printer->withError("Diretório `{$path}` Nao encontrado")->exit();
        }

        $created =  array_diff(scandir($path), ['.', '..']);

        if (!empty($created)) {
            foreach ($created as $file) {
                $filename = pathinfo($file, PATHINFO_FILENAME);
                if ($name == $filename) {
                    $this->printer->withError("O arquivo com esse nome `{$name}` já existe")->exit();
                }
            }
        }

        $sample = file_get_contents($sample_path . ucfirst($sample_name) . '.php');

        if ($sample_name == 'migration') {
            $id = $this->remove_s($name);


            if (str_contains($name, '_')) {
                $new_name = "Create";
                $named = explode('_', $name);
                foreach ($named as $index => $n) {
                    $new_name .= ($index == count($named) - 1) ? ucfirst($this->build_migration_table($n)) : ucfirst($n);
                }
                $new_name .= "Table";
            } else {
                $new_name = "Create" . ucfirst($this->build_migration_table($name)) . "Table";
            }
            $sample = str_replace('{' . "$sample_name" . '}', $new_name, $sample);
            $sample = str_replace(['{table}', '{table_id}'], [$this->build_migration_table($name), "{$id}_id"], $sample);
            $sample_file_name = $this->build_filename($this->database, $name, true);
        } else {
            $sample = str_replace('{' . "$sample_name" . '}', $name, $sample);
            $sample_file_name = $this->build_filename($path, $name, false);
        }

        if (file_put_contents($sample_file_name, $sample)) {
            $this->printer->withError("O arquivo foi criado com sucesso")->exit();
        }

        $this->printer->withError("Houve um erro ao criar o arquivo")->exit();
    }

    private function remove_s(string $table)
    {
        if ($table[strlen($table) - 1] == 's') {
            $table = substr($table, 0, strlen($table) - 1);
        }
        return $table;
    }

    private function build_migration_table(string $table)
    {
        if ($table[strlen($table) - 1] !== 's') {
            $table .= 's';
        }
        return $table;
    }

    private function build_filename(string $path, string $name, bool $is_migration)
    {
        if ($is_migration == false) {
            return $path . DIRECTORY_SEPARATOR . $name . '.php';
        }

        return $path . DIRECTORY_SEPARATOR . date('Y_m_d_00si') . "_" . "_create_{$name}_table.php";
    }


    private function make_migration(string $name)
    {
        $path = $this->database;
        $this->make('migration', $path, $name);
    }

    private function make_seeder(string $name)
    {
        $path = $this->seeder;
        $this->make('seeder', $path, $name);
    }

    private function make_model(string $name)
    {
        $path = $this->app . 'Models';
        $this->make('model', $path, $name);
    }

    private function migrate()
    {
        $migrations = array_values(array_diff(scandir($this->database), ['.', '..', 'leiame.txt']));

        echo "\033[0;33mDropping all the migrations\033[0m" . PHP_EOL;
        sleep(0.5);
        echo "\033[0;33mMigrations created successfully\033[0m" . PHP_EOL;
        sleep(0.8);

        //var_dump(env('DB_DATABASE'));exit;
        if (env('DB_DATABASE') == null)
            die ('Invalid database name');

        Schema::dropDbAndCreate(env('DB_DATABASE'));
        
        $inverted_actions = [];

        for ($i = count($migrations) - 1; $i >= 0; $i--) {
            //for ($i = 0; $i < count($migrations); $i++) {
            $filename = $migrations[$i];
            $migration = dirname(__DIR__, 3) . '/' . $this->database . "/$filename";

            //var_dump($migration);exit;

            include $migration;
            $filename = pathinfo($filename, PATHINFO_FILENAME);
            $action = explode('create_', $filename)[1];
            $action = explode('_table', $action)[0];
            if (str_contains($action, '_')) {
                $new_name = "Create";
                $named = explode('_', $action);
                foreach ($named as $index => $n) {
                    $new_name .= ($index == count($named) - 1) ? ucfirst($this->build_migration_table($n)) : ucfirst($n);
                }
                $new_name .= "Table";
            } else {
                $new_name = "Create" . ucfirst($this->build_migration_table($action)) . "Table";
            }

            $action = new $new_name();
            $action->down();
            $inverted_actions[] = $action;
        }

        for ($i = count($inverted_actions) - 1; $i >= 0; $i--) {
            $filename = pathinfo($migrations[$i], PATHINFO_FILENAME);
            echo "\033[0;32mMigrating: $filename\033[0m" . PHP_EOL;
            sleep(date('s')/60);
            $inverted_actions[$i]->up();
            echo "\033[0;33mMigrated: $filename (" . date('m:s') . "ms)\033[0m" . PHP_EOL;
            sleep(date('s')/60);
        }

        $db_seeder = new DatabaseSeeders();
        $db_seeder->seed();

        echo "\033[0;32mSeeding complete successfully\033[0m" . PHP_EOL;
        exit;
    }

    private function runServer()
    {
        $this->printer->withError("Starting server on http://127.0.0.1:8000\n");
        exec("php -S 127.0.0.1:8000 -t public");
    }
}
