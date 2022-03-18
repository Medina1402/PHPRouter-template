<?php
include_once __DIR__ . "/../../providers/php-router.php";
include_once __DIR__ . "/../../providers/Repository.php";

include_once __DIR__ . "/../../../database/migrations/Laboratories_table.php";
include_once __DIR__ . "/../../../database/migrations/Status_table.php";
include_once __DIR__ . "/../../../database/migrations/Rol_table.php";

$labRouter = new Router();

/**
 * Get all labs
 */
$labRouter->get("/api/lab", function (Request $request, Response $response) {
    $labs = Repository::findAll(Laboratories::class);
    $result = array();
    foreach ($labs as $lab) if ($lab instanceof Laboratories) $result[] = $lab->json();
    $response->json($result);
});

/**
 * Get one lab
 */
$labRouter->get("/api/lab/:id", function (Request $request, Response $response) {
    $lab = Repository::findId(Laboratories::class, $request->getValue("id"));
    if (!$lab) $response->json(["error" => "Lab no exist"]);
    if ($lab instanceof Laboratories);
    $response->json($lab->json());
});

/**
 * Create one lab
 * - Required Status ID
 */
$labRouter->post("/api/lab/create", function (Request $request, Response $response) {
    $status = Repository::findId(Status::class, $request->getParam("statusId"));
    if (!$status) $response->json(["error" => "Status no exist"]);
    if ($status instanceof Status);

    $lab = new Laboratories();
    $lab->description = $request->getParam("description");
    $lab->label = $request->getParam("label");
    $lab->setStatusId($status->getId());

    if (Repository::insert(Laboratories::class, $lab)) {
        $response->json($lab->json());
    }
    $response->json(["error" => "Failed created lab"]);
});

/**
 * Change Lab status => url?status=
 */
$labRouter->put("/api/lab/:id/update", function (Request $request, Response $response) {
    $status = Repository::findId(Status::class, $request->getParam("idStatus"));
    if (!$status) $response->json(["error" => "Status no exist"]);

    $lab = Repository::findId(Laboratories::class, $request->getValue("id"));
    if (!$lab) $response->json(["error" => "Laboratory no exist"]);

    if ($status instanceof Status and $lab instanceof Laboratories);
    $lab->setStatusId($status->getId());
    if (Repository::update(Laboratories::class, $lab, "id")) {
        $response->json(["message" => "Update successful"]);
    }
    $response->json(["error" => "Update unsuccessful"]);
});

/**
 * Delete the lab and its relationships.
 */
$labRouter->delete("/api/lab/:id/delete", function (Request $request, Response $response) {
    $lab = Repository::findId(Laboratories::class, $request->getValue("id"));
    if (!$lab) $response->json(["error" => "Lab no exist"]);

    if (Repository::delete(Laboratories::class, "id", $lab->getId())) {
        $response->json(["message" => "Delete successful"]);
    }
    $response->json(["error" => "Delete unsuccessful"]);
});