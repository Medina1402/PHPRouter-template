<?php
include_once __DIR__ . "/../../providers/php-router.php";
include_once __DIR__ . "/../../providers/Repository.php";

include_once __DIR__ . "/../../../database/migrations/Rol_table.php";

$rolRouter = new Router();

/**
 *
 */
$rolRouter->get("/api/rol", function (Request $request, Response $response) {
    $rol = Repository::findAll(Rol::class);
    $result = array();
    foreach ($rol as $lab) if ($lab instanceof Rol) $result[] = $lab->json();
    $response->json($result);
});

/**
 *
 */
$rolRouter->get("/api/rol/:id", function (Request $request, Response $response) {
    $rol = Repository::findId(Rol::class, $request->getValue("id"));
    if (!$rol) $response->json(["error" => "Rol no exist"]);
    if ($rol instanceof Rol);
    $response->json($rol->json());
});

/**
 *
 */
$rolRouter->post("/api/rol/create", function (Request $request, Response $response) {
    $rol = new Rol();
    $rol->description = $request->getParam("description");
    $rol->label = $request->getParam("label");

    if (Repository::insert(Rol::class, $rol)) {
        $response->json($rol->json());
    }
    $response->json(["error" => "Failed created rol"]);
});

/**
 * Update description => url?description=
 */
$rolRouter->put("/api/rol/:id/update", function (Request $request, Response $response) {
    $rol = Repository::findId(Rol::class, $request->getValue("id"));
    if (!$rol) $response->json(["error" => "Rol no exist"]);

    $rol->setStatusId($request->getParams("description"));
    if (Repository::update(Rol::class, $rol, "id")) {
        $response->json(["message" => "Update successful"]);
    }
    $response->json(["error" => "Update unsuccessful"]);
});

/**
 *
 */
$rolRouter->delete("/api/rol/:id/delete", function (Request $request, Response $response) {
    $rol = Repository::findId(Rol::class, $request->getValue("id"));
    if (!$rol) $response->json(["error" => "Rol no exist"]);

    if (Repository::delete(Rol::class, "id", $rol->getId())) {
        $response->json(["message" => "Delete successful"]);
    }
    $response->json(["error" => "Delete unsuccessful"]);
});