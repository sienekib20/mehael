<?php

namespace Sienekib\Mehael\Http;

class Controller
{
    /**
     * A instância da class controller
     * @var Controller
     */
    public Controller $system;

    /**
     * Constructor de inicialização
     */
    public function __construct()
    {
        $this->system = $this;
    }

    /**
     * Mensagem de erro
     */
    public function error(string $mensagem)
    {
        echo 'Mensagem de erro';

        exit;
    }

    /**
     * Data do sistema
     */
    public function date(string $formato = 'Y/m/d')
    {
        return date($formato);
    }

    /**
     * Cria o diretório caso não exista
     * 
     * @var string $base: 
     *      diretório dentro do qual vai se criar no novo diretório: $path
     * @var string $path: o novo diretório a ser criado 
     */
    public function build_path(string $base, string $path)
    {
        $base_dir = abs_path() . "/$base/";

        if (! file_exists($base_dir)) {
            return "Invalid base directory";
        }

        if (str_contains($path, '.')) {
            $paths = str_replace('.', '/', $path);
            if (file_exists($base_dir.$paths)) {
                return $base_dir.$paths.'/';
            }
            $base_dir .= $paths;    
        } else {
            $base_dir .= $path;
        }

        if (file_exists($base_dir)) {
            return "Directory already exists";
        }

        return mkdir($base_dir, 0777, true) ? "$base_dir/" : false;
    }

    // Colocar todas as preferencias que se vai precisar
}
