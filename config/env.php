<?php
/* ==========================================================================
   ENVIRONMENT LOADER MODULE (.env Parser for PHP)
   ========================================================================== */

if (!function_exists('load_env')) {
  function load_env($path = null) {
    if ($path === null) {
      $path = __DIR__ . '/../.env';
    }
    if (!file_exists($path)) {
      return;
    }
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
      $line = trim($line);
      if ($line === '' || strpos($line, '#') === 0) continue;
      if (strpos($line, '=') !== false) {
        list($name, $value) = explode('=', $line, 2);
        $name = trim($name);
        $value = trim($value);
        if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
          putenv("{$name}={$value}");
          $_ENV[$name] = $value;
          $_SERVER[$name] = $value;
        }
      }
    }
  }
}

// Automatically execute environment loader
load_env();
