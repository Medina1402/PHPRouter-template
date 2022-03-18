<?php
include_once __DIR__ . "/../application/providers/php-router.php";
include_once __DIR__ . "/../application/http/controller/LabsController.php";
include_once __DIR__ . "/../application/http/controller/RolController.php";
include_once __DIR__ . "/../application/http/controller/StatusController.php";
include_once __DIR__ . "/../application/http/controller/UserController.php";
include_once __DIR__ . "/../application/http/controller/ReservationController.php";

$api = new Router();

/** @var $labRouter */
/** @var $rolRouter */
/** @var $statusRouter */
/** @var $userRouter */
/** @var $reservationRouter */
$api->using($labRouter);
$api->using($rolRouter);
$api->using($statusRouter);
$api->using($userRouter);
$api->using($reservationRouter);