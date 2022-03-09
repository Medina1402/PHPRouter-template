<?php
include_once __DIR__ . "/../application/providers/php-router.php";
include_once "api.php";

include_once __DIR__ . "/../application/providers/Env.php";

$router = new Router();

/** @var $api */
$router->using($api);

$router
    ->get("/", function (Request $request, Response $response) {
        $response->render("public/index.html");
    })
    ->default("get", function (Request $request, Response $response) {
        $response->render("resources/views/error.html");
    });