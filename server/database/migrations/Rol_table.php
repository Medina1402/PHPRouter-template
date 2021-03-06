<?php
include_once __DIR__ . "/../../application/providers/Migration.php";

class Rol extends Migration {
    private ?int $id = null;
    public string $label;
    public string $description;

    public function schema(): string {
        $schema = "CREATE TABLE rol (
            id INT AUTO_INCREMENT PRIMARY KEY,
            label varchar(20) not null unique,
            description VARCHAR(255)
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
     * @return array
     */
    public function json(): array {
        return array();
    }
}