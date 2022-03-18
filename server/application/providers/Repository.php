<?php
include_once "Migration.php";

class Repository {
    /**
     * @param string $class
     * @param string $key
     * @param $value
     * @return object|null
     */
    public static function findOne(string $class, string $key, $value): ?object {
        $query = "select * from " . (new $class)->get_table_name() . " where $key='$value' limit 1";
        $result = self::executeQuery($class, $query);
        if ($result != null) return $result[0];
        return null;
    }

    /**
     * @param string $class
     * @param $id
     * @return object
     */
    public static function findId(string $class, $id): ?object {
        return self::findOne($class, "id", $id);
    }

    /**
     * @param string $class
     * @return array
     */
    public static function findAll(string $class): ?array {
        $query = "select * from " . (new $class)->get_table_name();
        return self::executeQuery($class, $query);
    }

    /**
     * @param string $class
     * @param array $args
     * @param string $join
     * @return array
     */
    public static function whereArgs(string $class, array $args, string $join = "and"): ?array {
        $where = "where";
        foreach ($args as $key => $value) {
            if(strlen($where) > 6) $where .= " $join";
            $where .= " $key$value";
        }
        $query = "select * from " . (new $class)->get_table_name() . " $where";
        return self::executeQuery($class, $query);
    }

    /**
     * @param string $class
     * @param $instance
     * @return bool
     */
    public static function insert(string $class, &$instance): bool {
        $data = self::getDataForDefinedInstance($instance, $class);
        $arrayForNewInstance = array();
        if ($instance instanceof Migration);
        $query = "insert into " . $instance->get_table_name() . " (";
        foreach ($data as $key => $value) {
            if ($value != null) {
                $arrayForNewInstance[$key] = "=" . ($value == strval(intval($value)) ? "$value" :"'".trim($value)."'") . " ";
                $query .= "$key,";
            }
        }

        $query .= ") values (";
        foreach ($data as $key => $value) {
            if ($value != null) $query .= ($value == strval(intval($value)) ?"$value," :"'".trim($value)."',");
        }
        $query .= ");";
        $query = str_replace(",)", ")", $query);

        $result = DB::query($query);
        if ($result) {
            $instance = self::whereArgs($class, $arrayForNewInstance)[0];
            return true;
        };
        return false;
    }

    /**
     * @param string $class
     * @param $instance
     * @param string $field_id
     * @return bool
     */
    public static function update(string $class, &$instance, string $field_id): bool {
        $data = self::getDataForDefinedInstance($instance, $class);
        if (!isset($data[$field_id])) return false;

        if ($instance instanceof Migration);
        $query = "update " . $instance->get_table_name() . " set ";
        foreach ($data as $key => $value) {
            if ($value != null and $key != $field_id) {
                $query .= "$key = " . ($value == strval(intval($value)) ? "$value" :"'$value'") . ", ";
            }
        }
        $query .= "where $field_id = " . $data[$field_id];
        $query = str_replace(", where", " where", $query);

        $result = DB::query($query);
        if ($result) {
            $instance = self::findOne($class, $field_id, $data[$field_id]);
            return true;
        };
        return false;
    }

    /**
     * @param string $class
     * @param string $key
     * @param $value
     * @return bool
     */
    public static function delete(string $class, string $key, $value): bool {
        $query = "delete from " . (new $class)->get_table_name() . " where $key = $value";
        return DB::query($query);
    }

    /**
     * @param $instance
     * @param string $class
     * @return array
     */
    private static function getDataForDefinedInstance($instance, string $class): array {
        $data = self::GetKeys($instance, $class);
        $keys = array();
        $reflexionClass = null;
        try { $reflexionClass = new ReflectionClass($instance); } catch (ReflectionException $e) { }

        foreach ($data["private"] as $key => $value) {
            $item = explode("]", $value);
            if (isset($item[1])) $keys[$item[0]] = $item[1];
            else {
                try {
                    $property = $reflexionClass->getProperty($item[0]);
                    $property->setAccessible(true);
                    $keys[$item[0]] = $property->getValue($instance);
                } catch (ReflectionException $e) {}
            }
        }
        return $keys;
    }

    /**
     * @param string $class
     * @param string $query
     * @return array
     */
    private static function executeQuery(string $class, string $query): array {
        $data = DB::query($query);
        $result = $data->fetch_all(MYSQLI_ASSOC);
        $items = array();
        foreach ($result as $value) {
            $instance = self::GetClassValues($class);
            if ($instance["class"] instanceof Migration);
            self::AssignValuesClass($instance, $value);
            $items[] = $instance["class"];
        }
        return $items;
    }

    /**
     * @param array $instance
     * @param array $result
     * @return void
     */
    private static function AssignValuesClass(array &$instance, array $result): void {
        try {
            $reflectionClass = new ReflectionClass($instance["class"]);

            foreach ($instance["keys"]["public"] as $field) {
                if (!$result[$field]) continue;
                $reflectionProperty = $reflectionClass->getProperty($field);

                if($reflectionProperty->getType()->getName() == "int") $result[$field] = (int) $result[$field];
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($instance["class"], trim($result[$field]));
            }

            foreach ($instance["keys"]["private"] as $field) {
                if (isset($result[$field])) {
                    $reflectionProperty = $reflectionClass->getProperty($field);

                    if($reflectionProperty->getType()->getName() === "int") $result[$field] = (int) $result[$field];
                    $reflectionProperty->setAccessible(true);
                    $reflectionProperty->setValue($instance["class"], trim($result[$field]));
                }
            }
        } catch (ReflectionException $e) {}
    }

    /**
     * @param string $class
     * @return array
     */
    private static function GetClassValues(string $class): array {
        $instance = array();
        $instance["class"] = new $class;
        if ( $instance["class"] instanceof Migration) $instance["keys"] = self::GetKeys($instance["class"], $class);
        else $instance["keys"] = null;
        return $instance;
    }

    /**
     * @param Migration $class
     * @param string $classname
     * @return array
     */
    private static function GetKeys(Migration $class, string $classname): array {
        $keys = array();
        $keys["public"] = array_keys(get_class_vars($classname));
        $private_keys = print_r($class, true);

        $str = str_replace("\n", "", $private_keys);
        $str = trim($str, " ");
        $str = str_replace("=>", "", $str);
        $str = str_replace(")", "", $str);
        $str = explode("(", $str)[1];
        $str = explode("[", $str);

        $private_keys = array();
        foreach ($str as $field) {
            $new_key = explode(":", $field)[0];
            if ($new_key != "") $private_keys[] = $new_key;
        }
        $keys["private"] = $private_keys;
        return $keys;
    }
}