<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Repositories\SendsRepository;
use App\Http\Repositories\ChannelsRepository;
use App\Http\Repositories\TemplatesRepository;


class SendController extends Controller
{
    
    private $sendsRepository;
    private $channelsRepository;
    private $templatesRepository;    
    
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(SendsRepository $sendsRepository, ChannelsRepository $channelsRepository, TemplatesRepository $templatesRepository)
    {
        $this->sendsRepository      = $sendsRepository;
        $this->channelsRepository   = $channelsRepository;
        $this->templatesRepository  = $templatesRepository;
    }

    /**
     * Show all user's sends
     *
     */
    public function index()
    {
        return $this->sendsRepository->all()->get();
    }

    /**
     * Show send by ID
     */
    public function get($id)
    {
        return $this->sendsRepository->find($id);
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
        $text = $template->text;
        $pattern = '/\{([\w]*)\}/i';
        $text = preg_replace_callback($pattern, function($matches) use ($dataArray) {
            return $dataArray[$matches[1]];
        }, $text);

        /* Сохраняем в отправках и присваиваем статус "отправлено" */
        $send = [
            'template_id'   => $template->id,
            'channel_id'    => $channel->id,
            'contact'       => $contact,
            'data'          => $data,
            'text'          => $text
        ];
        $this->sendsRepository->create($send);

        return $text;

    }

}
