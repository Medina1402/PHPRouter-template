<?php
include_once __DIR__ . "/../../application/providers/Migration.php";
include_once __DIR__ . "/../../application/providers/Repository.php";

include_once "Rol_table.php";

/**
 * Example:
 * $user = Repository::findOne(Users::class, "id", 2);
 * if ($user instanceof Users);
 * $response->send("Rol description of userId[". $user->getId() ."]: " . $user->getRol()->description);
 */
class Users extends Migration {
    private ?int $id = null;
    private ?int $rol_id = null;
    public string $username;
    public string $email;
    public string $password;
    public string $info;

    public function schema(): string {
        $schema = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            rol_id INT NOT NULL,
            username VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            info varchar(255),
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
     * @return int|null
     */
    public function getRolId(): ?int {
        return $this->rol_id;
    }

    /**
     * @param int|null $rol_id
     */
    public function setRolId(?int $rol_id): void {
        $this->rol_id = $rol_id;
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