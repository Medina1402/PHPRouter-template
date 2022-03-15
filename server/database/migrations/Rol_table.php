<?php
include_once __DIR__ . "/../../application/providers/Migration.php";

class Rol extends Migration {
    private ?int $id = null;
    public string $name;
    public string $description;

    public function schema(): string {
        $schema = "CREATE TABLE rol (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name varchar(20) unique not null,
            description VARCHAR(255)
        )";
        return $schema;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}