<?php

use App\Core\Router;
use App\Middleware\Admin;
use App\Middleware\Auth;
use App\Middleware\Guest;

Router::get('/', 'AuthController@index')->only(Guest::class);
Router::post('/login', 'AuthController@login')->only(Guest::class);
Router::delete("/logout", "AuthController@logout")->only(Auth::class);


Router::get("/dashboard", "PageController@dashboard")->only(Admin::class);

Router::get("/users", "UserController@index")->only(Admin::class);
Router::get("/users/create", "UserController@create")->only(Admin::class);
Router::post("/users", "UserController@store")->only(Admin::class);
Router::delete("/users/{id}", "UserController@delete")->only(Admin::class);
Router::get('/users/{id}/edit', 'UserController@edit')->only(Admin::class);
Router::put('/users/{id}', 'UserController@update')->only(Admin::class);

Router::get("/test", "PageController@test")->only(Auth::class);

Router::get("/konfiguracija", "ConfigurationController@index")->only(Admin::class);
Router::put("/konfiguracija/{key}", "ConfigurationController@update")->only(Admin::class);
Router::delete("/konfiguracija/{key}", "ConfigurationController@delete")->only(Admin::class);
