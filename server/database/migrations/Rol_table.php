<?php
include_once __DIR__ . "/../../application/providers/Migration.php";

/**
 * > Example
 * $rol = new Rol();
 * $rol->name = "admin";
 * $rol->description = "Access free";
 * $rol->save(); // insert or update
 * $response->send($rol);
 */
class Rol extends Migration {
    private ?int $id = null;
    public string $name;
    public string $description;

    public function schema(): string {
        $schema = "CREATE TABLE rol (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name varchar(20) unique not null,
            description VARCHAR(255)
        )";
        return $schema;
    }

    /**
     * TODO Crear funciones genericas para aplicar a todos los modelos, pasando solo parametros
     * @return bool
     */
    public function save(): bool {
        if ($this->id) return $this->update();
        $query = "insert into " . $this->get_table_name() . " (name, description) value ('$this->name', '$this->description')";
        DB::startTransactions();
        $result = DB::transaction($query);
        if($result) $select = DB::transaction("select * from " . $this->get_table_name() . " order by id desc limit 1");
        else $select = DB::transaction("select * from " . $this->get_table_name() . " where name = '$this->name'");
        if ($select) {
            $data = $select->fetch_assoc();
            $this->id = $data["id"];
            $this->name = $data["name"];
            $this->description = $data["description"];
        }
        DB::endTransaction();
        return $result;
    }

    private function update(): bool {
        $query = "update " . $this->get_table_name() . " set name=$this->name, description=$this->description";
        return DB::query($query) == 1;
    }

    public function __toString() {
        return "{ id: $this->id, name: $this->name, description: $this->description }";
    }
}