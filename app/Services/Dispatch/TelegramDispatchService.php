<?php

namespace App\Services\Dispatch;
use App\Http\Interfaces\DispatchServiceInterface;

/* TODO: для эмулиции получения статуса сообщения, надо знать его последний статус */
use App\Models\SendsStatus;
use App\Http\Repositories\SendsStatusesRepository;

/**
 * Отправка по Телеграм
 */
class TelegramDispatchService implements DispatchServiceInterface
{ 

    public function __construct()
    {
        
    }

    /**
     * Отправить Telegram
     */
    public function send($contact, $text)
    {
        //TODO: эмуляция отправки
        $status = rand(1, 13);
        if($status == 13) return 'fail';
        return 'success';
    }

    /**
     * Получить статус отправки Telegram
     */
    public function getStatus($id)
    {
        
        //TODO: эмуляция
        
        $repository = new SendsStatusesRepository((new SendsStatus()));
        
        $result = SendsStatus::where('send_id', $id)->orderBy('created_at', 'desc')->orderBy('id', 'desc')->first();
        $status = $result->status;

        switch ($status) {
            case 'send':
                $status = rand(1, 2);
                if($status == 2) $repository->receive($id);
                break;
            case 'received':
                $status = rand(1, 2);
                if($status == 2) {
                    $status = rand(1, 13);
                    if($status == 13) $repository->receiveFail($id);
                    else $repository->read($id);
                }
                break;
        }

        $result = SendsStatus::where('send_id', $id)->orderBy('created_at', 'desc')->orderBy('id', 'desc')->first();
        $status = $result->status;

        return $status;
    }

}