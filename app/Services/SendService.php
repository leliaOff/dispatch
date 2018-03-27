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
     * Get send's channel name
     */
    private function getSendsChannelName($sendId, $userId)
    {
        /* Находим сообщение */
        $send = $this->sendsRepository->find($sendId, $userId);
        if(empty($send)) {
            return false;
        }

        /* Находим канал отправки */
        $channel = $this->channelsRepository->find($send->channel_id);
        if(empty($channel)) {
            return false;
        }

        return $channel['name'];
    }

    /**
     * Send: { type: $TEMPLATESALIAS, channel: $CHANNELNAME, contact: $CONTACT, data: $DATA }
     */
    public function send($type, $channel, $contact, $data, $userId = false)
    {
        
        /* Находим шаблон */
        $template = $this->templatesRepository->findByAlias($type, $userId);
        if(empty($template)) {
            return 'template not found';
        }

        /* Находим канал отправки */
        $channel = $this->channelsRepository->findByName($channel);
        if(empty($channel)) {
            return 'channel not found';
        }

        /* Собираем сообщение */
        $text = (new ParserService())->getMessageText($template->text, $data);

        /* Сохраняем в отправках и присваиваем статус "создано" */
        $sendData = [
            'template_id'   => $template->id,
            'channel_id'    => $channel->id,
            'contact'       => $contact,
            'data'          => json_encode($data),
            'text'          => $text
        ];
        $send = $this->sendsRepository->create($sendData, $userId);

        /* Пытаемся отправить сообщение через диспетчер */
        $dispatcher = new StrategyDispatchService($channel['name']);
        if(!$dispatcher) {
            return 'dispatcher not found';
        }
        
        $result = $dispatcher->send($contact, $text);
        if($result == 'success') {
            (new SendsStatusesRepository())->send($send->id);
        } else {
            (new SendsStatusesRepository())->sendFail($send->id);
        }

        return $send->id;

    }

    /**
     * Resend
     */
    public function resend($sendId, $userId = false)
    {
        /* Находим канал отправки */
        $channelName = $this->getSendsChannelName($sendId, $userId);
        if(!$channelName) {
            return response('channel not found', 409);
        }

        /* Пытаемся отправить сообщение через диспетчер */
        $dispatcher = new StrategyDispatchService($channelName);
        if(!$dispatcher) {
            return 'dispatcher not found';
        }
        
        $result = $dispatcher->send($send->contact, $send->text);
        if($result == 'success') {
            (new SendsStatusesRepository())->send($send->id);
        } else {
            (new SendsStatusesRepository())->sendFail($send->id);
        }

        return $send->id;

    }

    /**
     * Получить статус отправки
     */
    public function status($sendId, $userId = false)
    {
        /* Находим канал отправки */
        $channelName = $this->getSendsChannelName($sendId, $userId);
        if(!$channelName) {
            return response('channel not found', 409);
        }
        
        /* Получаем статус через диспетчера */
        $dispatcher = new StrategyDispatchService($channelName);
        if(!$dispatcher) {
            return response('dispatcher not found', 409);
        }

        $result = $dispatcher->getStatus($sendId);

        return $result;

    }

    /**
     * Получить все статусы отправки
     */
    public function statuses($sendId, $userId = false)
    {
        /* Находим канал отправки */
        $channelName = $this->getSendsChannelName($sendId, $userId);
        if(!$channelName) {
            return response('channel not found', 409);
        }
        
        /* Получаем статус через диспетчера */
        $dispatcher = new StrategyDispatchService($channelName);
        if(!$dispatcher) {
            return response('dispatcher not found', 409);
        }

        $result = $dispatcher->getStatusesList($sendId);

        return $result;

    }

}