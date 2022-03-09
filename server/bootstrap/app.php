<?php
include_once __DIR__ . "/../routes/web.php";
include_once __DIR__ . "/../application/providers/Env.php";
include_once __DIR__ . "/../application/providers/Migration.php";

/** Load environment variables */
Env::init();

/* Load config database (migrations) */
if (Env::get("MIGRATIONS_DOWN") == "true") MountMigrations::down();
if (Env::get("MIGRATIONS_UP") == "true") MountMigrations::up();

/** Application @var $router */
$app = new Application($router);