<?php

/*
|--------------------------------------------
| Auto carregamento das classes
|--------------------------------------------
*/
require __DIR__ . '/vendor/autoload.php';

/*
|--------------------------------------------
| Responsável por todas as funcoes automáticas
|--------------------------------------------
*/
require __DIR__ . '/src/Support/helpers.php';


// Carregando variáveis de ambiente

$env = Dotenv\Dotenv::createImmutable(__DIR__ . '/');
$env->load();

// Executando o console
$alquimist = new Sienekib\Mehael\Console\Alquimist();
$alquimist->execute($argv, $argc);
