<?php
include_once __DIR__ . "/../../application/providers/Migration.php";

class Laboratories extends Migration {
    private ?int $id = null;
    private ?int $status_id = null; // get - set Foreign Key
    public string $description;

    public function schema(): string {
        $schema = "CREATE TABLE labs (
            id INT PRIMARY KEY,
            status_id INT,
            description VARCHAR(255),
            FOREIGN KEY (status_id) REFERENCES status (id)
        )";
        return $schema;
    }
}