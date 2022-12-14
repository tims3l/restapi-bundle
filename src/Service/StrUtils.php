<?php
declare(strict_types=1);

namespace Tims3l\RestApi\Service;

class StrUtils {
    
    public static function getClassBasename(string|object $class): string
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}