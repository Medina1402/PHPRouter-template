<?php
include_once __DIR__ . "/../../providers/php-router.php";
include_once __DIR__ . "/../../providers/Repository.php";

$reservationRouter = new Router();

/**
 *
 */
$reservationRouter->get("/api/reservations", function (Request $request, Response $response) {
    $reservations = Repository::findAll(Reservations::class);
    $result = array();
    foreach ($reservations as $reservation) if ($reservation instanceof Reservations) $result[] = $reservation->json();
    $response->json($result);
});