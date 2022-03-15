<?php
include_once __DIR__ . "/../../application/providers/Migration.php";
include_once __DIR__ . "/../../application/providers/Repository.php";

include_once "Status_table.php";

class Laboratories extends Migration {
    private ?int $id = null;
    private ?int $status_id = null;
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

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getStatusId(): ?int {
        return $this->status_id;
    }

    /**
     * @param int|null $status_id
     */
    public function setStatusId(?int $status_id): void {
        $this->status_id = $status_id;
    }

    /**
     * @return Status
     */
    public function getStatus(): Status {
        $status = Repository::findId(Status::class, $this->id);
        if ($status instanceof Status);
        return $status;
    }
}