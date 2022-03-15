<?php
include_once "Migration.php";

class Repository {
    /**
     * @param string $class
     * @param string $key
     * @param $value
     * @return object
     */
    public static function findOne(string $class, string $key, $value): object {
        $query = "select * from " . (new $class)->get_table_name() . " where $key='$value' limit 1";
        return self::executeQuery($class, $query)[0];
    }

    /**
     * @param string $class
     * @param $id
     * @return object
     */
    public static function findId(string $class, $id): object {
        return self::findOne($class, "id", $id);
    }

    /**
     * @param string $class
     * @return array
     */
    public static function findAll(string $class): array {
        $query = "select * from " . (new $class)->get_table_name();
        return self::executeQuery($class, $query);
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
                $reflectionProperty->setValue($instance["class"], $result[$field]);
            }

            foreach ($instance["keys"]["private"] as $field) {
                if (!$result[$field]) continue;
                $reflectionProperty = $reflectionClass->getProperty($field);

                if($reflectionProperty->getType()->getName() === "int") $result[$field] = (int) $result[$field];
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($instance["class"], $result[$field]);
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
     * @param $classname
     * @return array
     */
    private static function GetKeys(Migration $class, $classname): array {
        $keys = array();
        $keys["public"] = array_keys(get_class_vars($classname));
        $private_keys = print_r($class, true);

        $str = str_replace("\n", "", $private_keys);
        $str = str_replace(" ", "", $str);
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