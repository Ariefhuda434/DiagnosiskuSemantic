<?php

namespace App\helper;

use Illuminate\Http\Request;

class cutAfterChar 
{
  public static function cutBefore(string $text, string $char): string
    {
        $pos = strpos($text, $char);

        if ($pos !== false) {
            
            return substr($text, 0, $pos);
        }
        return $text;
    }
}
