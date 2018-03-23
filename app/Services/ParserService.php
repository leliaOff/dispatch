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

    /**
     * Gererate message text
     */
    public function getMessageText($template, $data)
    {
        $pattern = '/\{([\w]*)\}/i';
        $text = preg_replace_callback($pattern, function($matches) use ($data) {
            return $data[$matches[1]];
        }, $template);

        return $text;
    }
}