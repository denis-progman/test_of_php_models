<?php

if(!function_exists('env')) {
    function env(string $key, string $default = ''): string
    {
        return $_ENV[$key] ?? $default;
    }
}

if(!function_exists('setEnv')) {
    function setEnv(): void {
        $_ENV = parse_ini_file('.env', false, INI_SCANNER_RAW);
    }
}

if(!function_exists('config')) {
    function config(string $param, string $default = ''): mixed
    {
        $paramParts = explode('.', $param);
        $config = include 'config.php';
        foreach ($paramParts as $paramPart) {
            if (isset($config[$paramPart])) {
                $config = $config[$paramPart];
            } else {
                return $default;
            }
        }
        return $config;
    }
}
