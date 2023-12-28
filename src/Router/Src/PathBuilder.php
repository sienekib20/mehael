<?php

namespace Sienekib\Mehael\Router\Src;

use Exception;
use Sienekib\Mehael\Router\Src\Regex\RegexBuilder;

trait PathBuilder
{
    public function buildPathUri(string $route)
    {
        $path = explode('/', ltrim($route, '/'));
        $parameters = [];
        
        if (Wildcards::foundWildcards($route)) {
            $route = "/$path[0]/";
            foreach ($path as $wildcard) {
                if (Wildcards::check($wildcard)) {
                    $wildcard = str_replace(['(', ')'], '', $wildcard);
                    if (!str_contains($wildcard, ':')) {
                        throw new Exception('Wildcard mal formado.');
                    }
                    $wildcard = explode(':', $wildcard);
                    list($param, $pattern) = $wildcard;
                    $pattern = $this->correspondant($pattern);
                    $parameters[] = $param;
                    $route .= "$pattern/";

                }
            }
        }

        $route =  $this->build($route);
        return (object) ['uri' => ($route == '') ? '\/' : $route, 'params' => $parameters];
    }

    private function build(string $route)
    {
        return str_replace('/', '\/', rtrim($route, '/'));
    }

    public function routeParameters(array $parameters, array $matches)
    {
        if (empty($parameters)) {
            return [];
        }

        foreach ($matches as $key => $value) {
            $parameters[$parameters[$key]] = $value;
            unset($parameters[$key]);
        }

        return $parameters;
    }

    private function correspondant(string $type)
    {
        if ($type == 'any') {
            return RegexBuilder::any->value;
        }

        if ($type == 'alpha') {
            return RegexBuilder::alpha->value;
        }

        if ($type == 'numeric') {
            return RegexBuilder::numeric->value;
        }
    }
}
