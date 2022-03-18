<?php
include_once __DIR__ . "/../../application/providers/Repository.php";
include_once __DIR__ . "/../../application/providers/Hash.php";
include_once __DIR__ . "/../../application/providers/Env.php";

include_once __DIR__ . "/../migrations/Rol_table.php";
include_once __DIR__ . "/../migrations/Status_table.php";
include_once __DIR__ . "/../migrations/Users_table.php";

class Seeder {
    public static function run() {
        self::seeder_status();
        self::seeder_rol();
        self::seeder_user();
    }

    /**
     * @return void
     */
    private static function seeder_rol() {
        $array = array(
            array("label" => "ADMIN", "description" => "ADMIN"),
            array("label" => "USER", "description" => "USER"),
            array("label" => "GUEST", "description" => "GUEST")
        );

        foreach ($array as $item) {
            $instance = new Rol();
            $instance->label = $item["label"];
            $instance->description = $item["description"];
            Repository::insert(Rol::class, $instance);
        }
    }

    /**
     * @return void
     */
    private static function seeder_status() {
        $array = array(
            array("label" => "AVAILABLE", "description" => "AVAILABLE"),
            array("label" => "DISABLED", "description" => "DISABLED")
        );

        foreach ($array as $item) {
            $instance = new Status();
            $instance->label = $item["label"];
            $instance->description = $item["description"];
            Repository::insert(Status::class, $instance);
        }
    }

    /**
     * @return void
     */
    private static function seeder_user() {
        $array = array(
            array(
                "rol_name" => "ADMIN",
                "info" => "6649992365",
                "username" => Env::get("ROOT_USERNAME"),
                "email" => Env::get("ROOT_EMAIL"),
                "password" => Env::get("ROOT_PASSWORD")
            ),
            array(
                "rol_name" => "USER",
                "info" => "email@com65.mx",
                "username" => "user",
                "email" => "example@email.com",
                "password" => Env::get("ROOT_PASSWORD")
            ),
        );

        foreach ($array as $item) {
            $instance = new Users();
            $instance->username = $item["username"];
            $instance->email = $item["email"];
            $instance->info = $item["info"];
            $instance->setPassword(Hash::create($item["password"]));
            $instance->setRolId(
                Repository::findOne(Rol::class, "label", $item["rol_name"])->getId()
            );
            Repository::insert(Users::class, $instance);
        }
    }
}