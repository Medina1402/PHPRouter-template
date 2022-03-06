<?php
include_once __DIR__ . "/../resources/plugins/php-router.php";

$api = new Router();

$api->post("/labs", function (Request $request, Response $response) {
    $response->json([
        "date" => "15-25-2021",
        "data" => [
            "example" => ["one", "two"]
        ],
    ]);
});