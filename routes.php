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
Router::patch('/users/{id}', 'UserController@updatePassword')->only(Admin::class);

Router::get("/test", "PageController@test")->only(Auth::class);

Router::get("/podesavanja", "ConfigurationController@index")->only(Admin::class);
Router::put("/podesavanja/{key}", "ConfigurationController@update")->only(Admin::class);
Router::get("/api/podesavanja", "ConfigurationController@getAll")->only(Admin::class);


Router::get("/citaci", "CitaciController@index")->only(Admin::class);
Router::get("/api/citaci", "CitaciController@getAll")->only(Admin::class);
Router::get("/citaci/create", "CitaciController@create")->only(Admin::class);
Router::post("/citaci", "CitaciController@store")->only(Admin::class);
Router::delete("/citaci/{id}", "CitaciController@delete")->only(Admin::class);
Router::put('/citaci/{id}', 'CitaciController@update')->only(Admin::class);
Router::get('/citaci/{id}', 'CitaciController@getById')->only(Admin::class);
