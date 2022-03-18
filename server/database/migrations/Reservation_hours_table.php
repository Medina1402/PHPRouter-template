<?php
include_once __DIR__ . "/../../application/providers/Migration.php";
include_once __DIR__ . "/../../application/providers/Repository.php";

include_once "Reservations_table.php";

class Reservation_hours extends Migration {
    private ?int $id = null;
    private ?int $reservation_id = null;
    public int $hr_start;
    public int $hr_end;

    public function schema(): string {
        $schema = "create table reservation_hours (
            id int auto_increment primary key,
            reservation_id int,
            hr_start int not null ,
            hr_end int not null,
            foreign key (reservation_id) references reservation(id)
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
    public function getReservationId(): ?int {
        return $this->reservation_id;
    }

    /**
     * @param int|null $reservation_id
     */
    public function setReservationId(?int $reservation_id): void {
        $this->reservation_id = $reservation_id;
    }

    /**
     * @return Reservations
     */
    public function getReservation(): Reservations {
        $reservation = Repository::findId(Reservations::class, $this->reservation_id);
        if ($reservation instanceof Reservations);
        return $reservation;
    }

    /**
     * @return array
     */
    public function json(): array {
        return array();
    }
}