<?php

namespace App\Services\Dispatch;
use App\Http\Interfaces\DispatchServiceInterface;

/**
 * Отправка СМС
 */
class SmsDispatchService implements DispatchServiceInterface
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
     * Получить статус отправки СМС
     */
    public function getStatus($id)
    {
        
    }

}