<?php

namespace App\Services;

use App\Services\ParserService;
use App\Http\Repositories\SendsRepository;
use App\Http\Repositories\ChannelsRepository;
use App\Http\Repositories\TemplatesRepository;
use App\Http\Repositories\SendsStatusesRepository;
use App\Services\Dispatch\StrategyDispatchService;

class SendService
{
    private $sendsRepository;
    private $channelsRepository;
    private $templatesRepository;    
    
    public function __construct(SendsRepository $sendsRepository, ChannelsRepository $channelsRepository, TemplatesRepository $templatesRepository)
    {
        $this->sendsRepository      = $sendsRepository;
        $this->channelsRepository   = $channelsRepository;
        $this->templatesRepository  = $templatesRepository;
    }

    /**
     * Send: { type: $TEMPLATESALIAS, channel: $CHANNELNAME, contact: $CONTACT, data: $DATA }
     */
    public function send($type, $channel, $contact, $data)
    {
        
        /* Находим шаблон */
        $template = $this->templatesRepository->findByAlias($type);
        if(empty($template)) {
            return response('template not found', 409);
        }

        /* Находим канал отправки */
        $channel = $this->channelsRepository->findByName($channel);
        if(empty($channel)) {
            return response('channel not found', 409);
        }

        /* Разбираем данные */
        $dataArray = json_decode($data, true);

        /* Собираем сообщение */
        $text = (new ParserService())->getMessageText($template->text, $dataArray);

        /* Сохраняем в отправках и присваиваем статус "создано" */
        $sendData = [
            'template_id'   => $template->id,
            'channel_id'    => $channel->id,
            'contact'       => $contact,
            'data'          => $data,
            'text'          => $text
        ];
        $send = $this->sendsRepository->create($sendData);

        /* Пытаемся отправить сообщение через диспетчер */
        $dispatcher = new StrategyDispatchService($channel['name']);
        if(!$dispatcher) {
            return response('dispatcher not found', 409);
        }
        
        $result = $dispatcher->send($contact, $text);
        if($result == 'success') {
            (new SendsStatusesRepository())->send($send->id);
        } else {
            (new SendsStatusesRepository())->sendFail($send->id);
        }

        return response($result, 200);

    }

    /**
     * Получить статус отправки
     */
    public function status($id, $channel)
    {
        /* Получаем статус через диспетчера */
        $dispatcher = new StrategyDispatchService($channel);
        if(!$dispatcher) {
            return response('dispatcher not found', 409);
        }

        $result = $dispatcher->getStatus($id);

        return response($result, 200);

    }

}