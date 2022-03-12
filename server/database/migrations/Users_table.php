<?php
include_once __DIR__ . "/../../application/providers/Migration.php";

class Users extends Migration {
    private ?int $id = null;
    private ?int $rol_id = null; // get - set Foreign Key
    public string $username;
    public string $email;
    public string $password;
    public string $contact;

    public function schema(): string {
        $schema = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            contact varchar(255) default '-',
            rol_id INT NOT NULL,
            FOREIGN KEY (rol_id) REFERENCES rol (id)
        )";
        return $schema;
    }
}