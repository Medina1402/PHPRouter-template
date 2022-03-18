<?php
include_once __DIR__ . "/../../providers/php-router.php";
include_once __DIR__ . "/../../providers/Repository.php";

include_once __DIR__ . "/../../../database/migrations/Status_table.php";

$statusRouter = new Router();

/**
 *
 */
$statusRouter->get("/api/status", function (Request $request, Response $response) {
    $status = Repository::findAll(Status::class);
    $result = array();
    foreach ($status as $stat) if ($stat instanceof Status) $result[] = $stat->json();
    $response->json($result);
});

/**
 *
 */
$statusRouter->get("/api/status/:id", function (Request $request, Response $response) {
    $status = Repository::findId(Status::class, $request->getValue("id"));
    if (!$status) $response->json(["error" => "Rol no exist"]);
    if ($status instanceof Status);
    $response->json($status->json());
});

/**
 *
 */
$statusRouter->post("/api/status/create", function (Request $request, Response $response) {
    $status = new Rol();
    $status->description = $request->getParam("description");
    $status->label = $request->getParam("label");

    if (Repository::insert(Status::class, $status)) {
        $response->json($status->json());
    }
    $response->json(["error" => "Failed created rol"]);
});

/**
 * Update description => url?description=
 */
$statusRouter->put("/api/status/:id/update", function (Request $request, Response $response) {
    $status = Repository::findId(Status::class, $request->getValue("id"));
    if (!$status) $response->json(["error" => "Status no exist"]);

    $status->setStatusId($request->getParams("description"));
    if (Repository::update(Status::class, $status, "id")) {
        $response->json(["message" => "Update successful"]);
    }
    $response->json(["error" => "Update unsuccessful"]);
});

/**
 *
 */
$statusRouter->delete("/api/status/:id/delete", function (Request $request, Response $response) {
    $status = Repository::findId(Status::class, $request->getValue("id"));
    if (!$status) $response->json(["error" => "Status no exist"]);

    if (Repository::delete(Status::class, "id", $status->getId())) {
        $response->json(["message" => "Delete successful"]);
    }
    $response->json(["error" => "Delete unsuccessful"]);
});