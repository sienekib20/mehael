<?php

namespace Sienekib\Mehael\Http\Src;

trait Uri
{
    public function uri()
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';

        $prefix = $this->prefix();

        $uri = explode($prefix, $uri);

        return end($uri);
    }

    private function prefix()
    {
        return basename(abs_path());
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