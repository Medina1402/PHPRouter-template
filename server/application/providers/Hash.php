<?php

class Hash {
    /**
     * @param string $value
     * @return string
     */
    public static function create(string $value): string {
        return password_hash($value, PASSWORD_BCRYPT, [ "cost" => 12 ]);
    }

    /**
     * @param string $value
     * @param string $hash
     * @return bool
     */
    public static function verify(string $value, string $hash): bool {
        return password_verify($value, $hash);
    }
}