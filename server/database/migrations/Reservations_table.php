<?php
include_once __DIR__ . "/../../application/providers/Migration.php";

class Reservations extends Migration {
    private ?int $id = null;
    private ?int $user_id = null;      // get - set Foreign Key
    private ?int $lab_id = null;       // get - set Foreign Key
    public string $day_start;         // get - set Date
    public int $weeks;

    public function schema(): string {
        $schema = "CREATE TABLE reservation (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            lab_id INT,
            day_start DATE NOT NULL,
            weeks INT,
            FOREIGN KEY (user_id) REFERENCES users (id),
            FOREIGN KEY (lab_id) REFERENCES labs (id)
        )";
        return $schema;
    }
}