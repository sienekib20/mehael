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
        $_REQUEST = $request;

        $this->renderRequestedData();
    }

    private function renderRequestedData()
    {
        $data = [];

        foreach ($_REQUEST as $key => $value) {
            $data[$key] = strip_tags($value);
        }

        $this->data = $data;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }
}
