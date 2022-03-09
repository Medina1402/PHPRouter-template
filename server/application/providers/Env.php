<?php

/**
 * Manage environment ".env"
 * Is required exist in root folder
 */
class Env {
    /**
     * Register variables in var global $_ENV
     * @return void
     */
    static function init(): void {
        $path_file = __DIR__ . "/../../.env";
        $stream_file = fopen($path_file, "r");
        $content_file = fread($stream_file, filesize($path_file));
        fclose($stream_file);

        $vars_and_values = explode("\n", $content_file);

        foreach ($vars_and_values as $value) {
            $key_value = explode("=", $value);
            if (sizeof($key_value) == 2) $_ENV[$key_value[0]] = trim($key_value[1]);
        }
    }

    /**
     * Get value of environment variable, if exists
     * @param string $name
     * @return string
     */
    static function get(string $name): string {
        return $_ENV[$name];
    }
}