<?php

namespace App\Services;

use App\Services\ParserService;
use App\Http\Repositories\SendsRepository;
use App\Http\Repositories\ChannelsRepository;
use App\Http\Repositories\TemplatesRepository;

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

        /* Сохраняем в отправках и присваиваем статус "отправлено" */
        $send = [
            'template_id'   => $template->id,
            'channel_id'    => $channel->id,
            'contact'       => $contact,
            'data'          => $data,
            'text'          => $text
        ];
        $this->sendsRepository->create($send);

        return response('success', 200);

    }

}