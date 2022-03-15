<?php
include_once __DIR__ . "/../../application/providers/Migration.php";

include_once "Rol_table.php";

/**
 * Example:
 * $user = Repository::findOne(Users::class, "id", 2);
 * if ($user instanceof Users);
 * $response->send("Rol description of userId[". $user->getId() ."]: " . $user->getRol()->description);
 */
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

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return Rol
     */
    public function getRol(): Rol {
        $rol = Repository::findId(Rol::class, $this->rol_id);
        if ($rol instanceof Rol);
        return $rol;
    }
}