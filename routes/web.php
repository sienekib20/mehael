<?php

use App\Http\Controllers\User;
use Sienekib\Mehael\Router\Anotation\Route;

Route::add('GET', '/', [User::class, 'index']);

Route::add('GET', '/show/(name:alpha)/(id:numeric)', function() {
    echo 'Here';
});

Route::prefix('admin')->group('auth:authorize', function() {
    Route::add('GET', '/compras', function() {
        echo 'Compras';
    });

    Route::add('GET', '/users', function() {
        echo 'Users';
    });
});

Route::prefix('parametrizacao')->group('auth:web1', function() {
    Route::add('GET', '/aulas', function() {
        echo 'Aulas';
    });

    Route::add('GET', '/classes', function() {
        echo 'Classes';
    });
});

Route::add('GET', '/login', function() {
    echo 'Login';
});