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

    // Colocar todas as preferencias que se vai precisar
}
