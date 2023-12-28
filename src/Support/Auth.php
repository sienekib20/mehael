<?php
declare(strict_types=1);

namespace Sienekib\Mehael\Support;


class Auth
{
    private static array $data = [];

    public static function create(array $data)
    {
        $dados = array();

        if (is_object($data)) {
            $data = (array) $data;
        }

        if (!is_array($data)) {
            $data = [$data];
        }

        foreach ($data as $key => $value) {
            $dados[$key] = &$value;
        }


        self::$data = &$dados;
    }

    public function __get(string $key)
    {
        return self::$data[$key] ?? null;
    }
}
