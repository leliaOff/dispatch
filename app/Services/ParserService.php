<?php

namespace App\Services;

class ParserService
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        // ...
    }

    /**
     * Contacts data string parsing to array
     */
    public function getContactsDataAsArray($string)
    {
        preg_match_all("/([\w\@\+\.]+)/i", $string, $matches);
        return $matches[1];
    }
}