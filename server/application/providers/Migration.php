<?php
include_once __DIR__ . "/../../database/db.php";

/**
 *
 */
abstract class Migration {
    /**
     * Create schema (table for database)
     * @return string
     */
    public abstract function schema(): string;

    private function get_table_name(): string {
        $schema = trim(strtolower($this->schema()));
        $temp = explode("create table", $schema);
        return trim(explode("(", $temp[1])[0]);
    }

    /**
     * Run the migration
     * @return void
     */
    public function up(): void {
        $schema = trim(strtolower($this->schema()));
        if (strpos($schema, "create table")) return;
        DB::query("$schema");
    }

    /**
     * Reverse migration
     * @return void
     */
    public function down(): void {
        $table = $this->get_table_name();
        DB::query("drop table $table");
    }
}

/**
 * Read all migrations and execute called sentence
 */
class MountMigrations {
    /**
     * Read migration for /database/migrations and get all instances
     * @return array
     */
    private static function readMigrations(): array {
        $dir = __DIR__ . "/../../database/migrations";
        $files = scandir($dir);
        $migrations = [];

        foreach ($files as $file) {
            $schema_name = explode("_table", $file);
            if ( sizeof($schema_name) == 2 ) {
                include_once realpath("$dir/$file");
                $temp = new $schema_name[0];
                if( $temp instanceof Migration ) $migrations[] = $temp;
            }
        }

        return $migrations;
    }

    /**
     * @return void
     */
   public static function up(): void {
       $migrations = self::readMigrations();
        if ( $migrations == [] ) return;

        foreach ($migrations as $migration) {
            if( $migration instanceof Migration ) $migration->up();
        }
   }

    /**
     * @return void
     */
   public static function down(): void {
       $migrations = self::readMigrations();
       if ( $migrations == [] ) return;

       foreach ($migrations as $migration) {
           if( $migration instanceof Migration ) $migration->down();
       }
   }
}