<?php

namespace Sienekib\Mehael\Http;

use Sienekib\Mehael\Http\Src\Uri;

class Request
{
    use Uri;

    private array $data = [];

    public function __construct()
    {
        $this->renderRequestedData();
    }

    public function bind(array $request)
    {
        if ($this->method() == 'GET') {
            $_GET = $request;
        }

        if ($this->method() == 'POST') {
            $_POST = $request;
        }

        $this->renderRequestedData();
    }

    private function renderRequestedData()
    {
        if ($this->method() == 'GET') {
            foreach ($_GET as $key => $value) {
                $this->data[$key] = strip_tags($value);
            }
        }

        if ($this->method() == 'POST') {
            foreach ($_POST as $key => $value) {
                $this->data[$key] = strip_tags($value);
            }
        }

        $this->data;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }
}
