<?php

use App\Core\Router;
use App\Middleware\Admin;
use App\Middleware\Auth;
use App\Middleware\Guest;

Router::get('/', 'PageController@login')->only(Guest::class);

Router::post('/login', 'AuthController@login')->only(Guest::class);
Router::get("/dashboard", "PageController@dashboard")->only(Admin::class);

Router::delete("/logout", "AuthController@logout")->only(Auth::class);

Router::get("/users", "UserController@index")->only(Admin::class);
Router::get("/users/create", "UserController@create")->only(Admin::class);
Router::post("/users", "UserController@store")->only(Admin::class);
Router::delete("/users/{id}", "UserController@delete")->only(Admin::class);
Router::get('/users/{id}/edit', 'UserController@edit')->only(Admin::class);
Router::put('/users/{id}', 'UserController@update')->only(Admin::class);

Router::get("/test", "PageController@test")->only(Auth::class);