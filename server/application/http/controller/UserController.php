<?php
include_once __DIR__ . "/../../providers/php-router.php";
include_once __DIR__ . "/../../providers/Repository.php";

include_once __DIR__ . "/../../../database/migrations/Users_table.php";
include_once __DIR__ . "/../../../database/migrations/Rol_table.php";

$userRouter = new Router();

/**
 *
 */
$userRouter->get("/api/users", function (Request $request, Response $response) {
    $users = Repository::findAll(Users::class);
    $result = array();
    foreach ($users as $user) if ($user instanceof Users) $result[] = $user->json();
    $response->json($result);
});

/**
 *
 */
$userRouter->get("/api/users/:id", function (Request $request, Response $response) {
    $user = Repository::findId(Users::class, $request->getValue("id"));
    if (!$user) $response->json(["error" => "User no exist"]);
    if ($user instanceof Users);
    $response->json($user->json());
});

/**
 *
 */
$userRouter->post("/api/users/create", function (Request $request, Response $response) {
    $rol = Repository::findId(Rol::class, $request->getParam("rolId"));
    if (!$rol) $response->json(["error" => "Rol no exist"]);
    if ($rol instanceof Rol);

    $user = new Users();
    $user->username = $request->getParam("username");
    $user->email = $request->getParam("email");
    $user->info = $request->getParam("info");
    $user->setRolId($rol->getId());
    $user->setPassword(Hash::create($request->getParam("password")));

    if (Repository::insert(Users::class, $user)) {
        $response->json($user->json());
    }
    $response->json(["error" => "Failed created User"]);
});

/**
 * Update: info, email, username, password, role
 */
$userRouter->put("/api/users/:id/update", function (Request $request, Response $response) {
    $response->json(["error" => "Failed update User"]);
});

/**
 *
 */
$userRouter->delete("/api/users/delete", function (Request $request, Response $response) {
    $user = Repository::findId(Users::class, $request->getValue("id"));
    if (!$user) $response->json(["error" => "User no exist"]);

    if (Repository::delete(Users::class, "id", $user->getId())) {
        $response->json(["message" => "Delete successful"]);
    }
    $response->json(["error" => "Delete unsuccessful"]);
});