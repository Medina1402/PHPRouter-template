<?php
include_once __DIR__ . "/../resources/plugins/php-router.php";
include_once "api.php";

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