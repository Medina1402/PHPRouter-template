<?php
include_once __DIR__ . "/../../providers/php-router.php";
include_once __DIR__ . "/../../providers/Repository.php";
include_once __DIR__ . "/../../../database/migrations/Laboratories_table.php";

$router = new Router();

$router->post("/api/lab/create", function (Request $request, Response $response) {

});