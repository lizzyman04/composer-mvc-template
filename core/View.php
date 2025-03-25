<?php

namespace Core;
require_once __DIR__ . '/../config/config.php';

use Exception;

class View
{
    public static function render($view, $data = null)
    {
        $file = BASE_PATH . '/src/Views/' . $view . '.php';
        
        if (file_exists($file)) {
            if ($data) {
                extract($data);
            }
            require_once $file;
        } else {
            throw new Exception("View '$view' not found!");
        }
    }
}
