<?php
include_once __DIR__ . "/../../application/providers/Migration.php";
include_once __DIR__ . "/../../application/providers/Repository.php";

include_once "Laboratories_table.php";
include_once "Users_table.php";

class Reservations extends Migration {
    private ?int $id = null;
    private ?int $user_id = null;
    private ?int $lab_id = null;
    public string $day_start;
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

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getUserId(): ?int {
        return $this->user_id;
    }

    /**
     * @param int|null $user_id
     */
    public function setUserId(?int $user_id): void {
        $this->user_id = $user_id;
    }

    /**
     * @return Users
     */
    public function getUser(): Users {
        $user = Repository::findId(Users::class, $this->user_id);
        if ($user instanceof Users);
        return $user;
    }

    /**
     * @return int|null
     */
    public function getLabId(): ?int {
        return $this->lab_id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void {
        $this->id = $id;
    }

    /**
     * @return Laboratories
     */
    public function getLab(): Laboratories {
        $lab = Repository::findId(Laboratories::class, $this->lab_id);
        if ($lab instanceof Laboratories);
        return $lab;
    }

    /**
     * @return array
     */
    public function json(): array {
        return array();
    }
}