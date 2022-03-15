<?php
include_once __DIR__ . "/../../application/providers/Migration.php";

class Reservation_hours extends Migration {
    private ?int $id = null;
    private ?int $reservation_id = null; // get - set Foreign Key
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
}