<?php

namespace Sienekib\Mehael\Template;

class View
{
    public static function render(string $view, array $params)
    {
        if (!str_contains($view, ':')) {
            echo "View `$view` mal formada";
            exit;
        }
        $path = view_path() . '/';
        $parts = explode(':', $view);

        if (empty($parts[0])) {
            echo "Precisa definir um título para sua tela";
            exit;
        }

        if (str_contains($parts[1], '.')) {
            $views = explode('.', $parts[1]);
            foreach ($views as $view) {
                if (is_dir($path . $view)) {
                    $path = $path . $view . '/';
                }
            }
            $view = $path . end($views) . '.php';
        } else {
            $view = $path . $parts[1] . '.php';
        }

        if (!file_exists($view)) {
            echo "Tela não encontrado";
            response()->setStatusCode(404);
            exit;
        }

        foreach($params as $key => $value) {
            $$key = $value;
        }

        ob_start();

        require $view;

        $final = ob_get_clean();

        $final = preg_replace("/<title>(.*)<\/title>/", "<title>$parts[0]</title>", $final);

        echo $final;

        return;
    }
}
