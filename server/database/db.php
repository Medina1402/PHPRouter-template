<?php

/**
 * State management for database connection
 * It only opens and closes connections, and executes string queries
 */
class DB {
    /**
     * Create connection mysql, is necessary closed
     * @return mysqli
     */
    private static function connection(): mysqli {
        $connection = mysqli_connect(
            Env::get("DB_HOST"),
            Env::get("DB_USERNAME"),
            Env::get("DB_PASSWORD"),
            Env::get("DB_DATABASE"),
            intval(Env::get("DB_PORT"))
        );
        if ( !$connection ) die("Failed Connection DB");
        return $connection;
    }

    /**
     * Close connection defined
     * @param mysqli $connect
     * @return void
     */
    private static function close(mysqli $connect): void {
        $connect->close();
    }

    /**
     * Execute query, open and close connection
     * @param string $query
     * @return bool|mysqli_result
     */
    public static function query(string $query) {
        $connection = self::connection();
        $result = $connection->query($query);
        self::close($connection);
        return $result;
    }
}