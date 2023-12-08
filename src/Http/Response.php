<?php

namespace Sienekib\Mehael\Http;

class Response
{
    private array $headers = [];

    private int $status_code = 200;

    public function __construct()
    {
        //$this->headers = getallheaders();
    }

    public function setStatusCode(int $status)
    {
        $this->status_code = $status;

        http_response_code($this->status_code);
    }

    public function json(array $data)
    {
        $this->setHeader("Content-Type", "application/json");
        $this->applyHeaders();

        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
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
