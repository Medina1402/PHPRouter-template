<?php
include_once __DIR__ . "/../routes/web.php";
include_once __DIR__ . "/../application/providers/Env.php";
include_once __DIR__ . "/../application/providers/Migration.php";
include_once __DIR__ . "/../database/seeds/Seeder.php";

/** Load environment variables */
Env::init();

/* Load config database (migrations) */
if (Env::get("MIGRATIONS_DOWN") == "true") MountMigrations::delete();
if (Env::get("MIGRATIONS_UP") == "true") MountMigrations::create();

/* Insert data default */
if (Env::get("SEEDERS") == "true") Seeder::run();

/** Application @var $router */
$app = new Application($router);