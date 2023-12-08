<?php

namespace Sienekib\Mehael\Router;

use Sienekib\Mehael\Router\Src\PathBuilder;
use Sienekib\Mehael\Router\Src\Wildcards;

class AbstractRoute
{
    use PathBuilder, Dispatcher;
}