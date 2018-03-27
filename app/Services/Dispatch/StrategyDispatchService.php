<?php

namespace App\Services\Dispatch;
use App\Services\Dispatch\SmsDispatchService;
use App\Services\Dispatch\EmailDispatchService;
use App\Services\Dispatch\TelegramDispatchService;
use App\Http\Interfaces\DispatchServiceInterface;

/**
 * Сервис определяет, каким классом будет осуществленна отправка сообщения
 */
class StrategyDispatchService implements DispatchServiceInterface
{ 
    /**
     * Диспетчер отправки
     */
    private $dispatcher;

    /**
     * Класс диспетчера определяется в зависимости от типа (канала) передачи
     */
    public function __construct($type)
    {
        switch ($type) {
            case 'sms':
                $this->dispatcher = new SmsDispatchService();
                break;
            case 'email':
                $this->dispatcher = new EmailDispatchService();
                break;
            case 'telegram':
                $this->dispatcher = new TelegramDispatchService();
                break;
            default:
                $this->dispatcher = false;
                break;
        }
    }

    /**
     * Отправить сообщение через нужный диспетчер
     */
    public function send($contact, $text)
    {
        return $this->dispatcher->send($contact, $text);
    }

    /**
     * Получить статус сообщения
     */
    public function getStatus($id)
    {
        return $this->dispatcher->getStatus($id);
    }

    /**
     * Получить всю историю статусов сообщения
     */
    public function getStatusesList($id)
    {
        return $this->dispatcher->getStatusesList($id);
    }

}