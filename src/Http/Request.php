<?php

namespace Sienekib\Mehael\Http;

use Sienekib\Mehael\Http\Src\Uri;
use Sienekib\Mehael\Http\Json\Jsonable;

class Request
{
    use Uri;
    use Jsonable;

    private array $data = [];

    public function __construct()
    {
        $this->jsonable();
        $this->renderRequestedData();
    }

    public function jsonable()
    {
        $data = $this->get_contents() ?? [];

        foreach ($data as $key => $value) {
            $countable = (is_object($value)) ? $value : [$key => $value]; 
            foreach ($countable as $index => $val) {
                $this->data[$index] = $val;
            }
        }
    }

    public function base64File(string $filename)
    {
        if ($this->$filename !== null) {
            $base64 = $this->$filename;
            $file = explode('base64', $base64)[1];
            return base64_decode($file);
        }
        return null;
    }

    public function base64FileExtension(string $filename, $type = 'img')
    {
        if (! str_contains($this->$filename, '.')) {
            return 'Invalid filename';
        }

        $extension = explode('.', $this->$filename)[1];

        return $this->matchExtension($extension, $type) ? $extension : null;
    }

    private function matchExtension($ext, $type)
    {
        $ext = strtolower($ext);

        if ($type == 'img') {
            return $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'webp';
        }


        if ($type == 'video') {
            return $ext == 'mp4' || $ext == 'mkv' || $ext == 'moov';
        }
    }

    public function all()
    {
        return (object) $this->data;
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

        return $this->data;
    }

    public function __get($key)
    {
        return $this->data[$key] ?? null;
    }
}
