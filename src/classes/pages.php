<?php

declare(strict_types=1);

class Pages
{
    /**Gets all the file names is the pages fold*/
    public static function get(): array
    {
        $arr = array_reverse(glob("pages/*.php"));
        return array_map(function($result) 
        {
            return substr($result, strlen("pages/"), strlen($result) - strlen($result) - 4);
        }, $arr);
    }
}
// 

?>