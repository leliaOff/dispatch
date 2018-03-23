<?php

namespace App\Services\Dispatch;
use App\Http\Interfaces\DispatchServiceInterface;

/**
 * Отправка Email
 */
class EmailDispatchService implements DispatchServiceInterface
{ 

    public function __construct()
    {
        
    }

    /**
     * Отправить СМС
     */
    public function send($contact, $text)
    {
        
    }

    /**
     * Получить статус отправки Email
     */
    public function getStatus($id)
    {
        
    }

}