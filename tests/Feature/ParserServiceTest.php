<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\ParserService;

class ParserServiceTest extends TestCase
{
     /**
     * Contacts data string parsing to array
     */
    public function testGetContactsDataAsArray()
    {
        
        $string = '+79608554570 89608554570,89648832144, +79648832144';
        $result = ['+79608554570', '89608554570', '89648832144', '+79648832144'];

        $parserService = new ParserService();
        
        $contacts = $parserService->getContactsDataAsArray($string);
        if($contacts == $result) return $this->assertTrue(true);

        return $this->assertTrue(false);
    }

    /**
     * Gererate message text
     */
    public function testGetMessageText()
    {
        $template = 'Привет {username}! Хочешь скидку {sale}%?';
        $data = ['username' => 'Василий Иванович', 'sale' => 20];
        $result = 'Привет Василий Иванович! Хочешь скидку 20%?';

        $parserService = new ParserService();

        $message = $parserService->getMessageText($template, $data);
        if($message == $result) return $this->assertTrue(true);

        return $this->assertTrue(false);
    }
}
