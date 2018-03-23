<?php

namespace App\Services\Dispatch;
use App\Http\Interfaces\DispatchServiceInterface;

/**
 * Отправка по Телеграм
 */
class TelegramDispatchService implements DispatchServiceInterface
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
     * Получить статус отправки Telegram
     */
    public function getStatus($id)
    {
        
    }

}