<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SendService;
use App\Services\ParserService;
use Illuminate\Validation\Rule;
use App\Http\Repositories\SendsRepository;

class SendController extends Controller
{
    
    private $sendsRepository;  
    private $sendService;  
    
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(SendsRepository $sendsRepository, SendService $sendService)
    {
        $this->sendsRepository = $sendsRepository;
        $this->sendService     = $sendService;
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
     * Multiple Sending
     */
    public function create(Request $request)
    {

        $this->validate($request, [
            'template'      => 'required|string',
            'channels'      => 'required|array',
            'channels.*'    => 'required|string',
            'contacts'      => 'required|array',
            'data'          => 'required|array',
        ]);

        $template   = $request['template'];
        $channels   = $request['channels'];
        $contacts   = $request['contacts'];
        $data       = $request['data'];

        /* Разбираем контактные данные */
        $contactsData = [];
        $parser = new ParserService();
        foreach($contacts as $type => $value) {
            $contactsData[$type] = $parser->getContactsDataAsArray($value);
        }

        /* Данные, заполненные пользователь, должны быть в json */
        $dataJson = json_encode($data);

        /* Делаем отправку по каждому каналу и для всех контактов */
        $result = [];
        foreach($channels as $channel => $contactsType) {

            /* Список контактных данных под ключам типа контактных данных */
            $contactsDataByType = $contactsData[$contactsType];

            /* Отправляем всем, кто в списке */
            foreach($contactsDataByType as $contact) {
                $result[] = $this->send($template, $channel, $contact, $dataJson);
            }
            
        }

        return response($result, 200);
    }

    /**
     * Send
     */
    public function send($type, $channel, $contact, $data)
    {
        return $this->sendService->send($type, $channel, $contact, $data);
    }

}
