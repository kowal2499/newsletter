<?php

namespace Newsletter\Core;

class Tools
{
    public static function redirect($target = '/')
    {
        if (strpos($target, 'http') === false) {
            $target = URL.$target;
        }
        header("Location: ".$target, true);
    }
}
