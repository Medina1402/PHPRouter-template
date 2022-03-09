<?php
include_once __DIR__ . "/../routes/web.php";
include_once __DIR__ . "/../resources/services/Env.php";

/** Load environment variables */
Env::init();

/** Application @var $router */
$app = new Application($router);