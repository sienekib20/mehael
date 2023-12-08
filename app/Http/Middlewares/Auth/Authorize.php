<?php

namespace App\Http\Middlewares\Auth;

use Sienekib\Mehael\Support\Session;

class Authorize
{
    public function handle()
    {
        $restricted = Session::has('user_id');

        if (!$restricted) {

            header('Location: /login');
            exit;
        }
    }
}
