<?php

namespace Sienekib\Mehael\Http\Src;

trait Uri
{
    public function uri()
    {
        return $_SERVER['REQUEST_URI'] ?? '';
    }

    public function path()
    {
        return $this->uri();
    }

    public function method()
    {
        return $_SERVER['REQUEST_METHOD'] ?? 'GET';
    }
}