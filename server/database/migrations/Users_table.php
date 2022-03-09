<?php
include_once __DIR__ . "/../../application/providers/Migration.php";

class Users extends Migration {
    public function schema(): string {
        return "create table usuarios (LastName varchar(255), FirstName varchar(255), Address varchar(255), City varchar(255));";
    }
}