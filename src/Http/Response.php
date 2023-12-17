<?php

namespace Sienekib\Mehael\Http;

class Response
{
    private array $headers = [];

    private int $status_code = 200;

    public function __construct()
    {
        //$this->headers = getallheaders();
        $this->setHeader('Access-Control-Allow-Origin','*');
        $this->setHeader('Access-Control-Allow-Headers','*');
        $this->setHeader('Access-Control-Allow-Credentials','true');
        $this->setHeader('Access-Control-Allow-Methods','GET, POST, OPTIONS');
    }

    public function setStatusCode(int $status)
    {
        $this->status_code = $status;

        http_response_code($this->status_code);
    }

    public function json(mixed $data)
    {
        $data = (is_array($data)) ? $data : [$data];

        $this->setHeader("Content-Type", "application/json");
        $this->applyHeaders();

        echo json_encode($data, JSON_UNESCAPED_UNICODE);

        exit;
    }

    public function setHeader(string $type, string $value)
    {
        $this->headers[$type] = $value;
    }

    public function applyHeaders()
    {
        if (!empty($this->headers)) {
            foreach ($this->headers as $type => $value) {
                header("$type: $value");
            }
        }
        $this->headers = [];
    }
}
