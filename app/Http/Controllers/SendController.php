<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SendService;
use App\Services\ParserService;
use Illuminate\Validation\Rule;
use App\Http\Repositories\SendsRepository;
use App\Http\Repositories\UsersAuthRepository;
use App\Http\Interfaces\SendControllerInterface;

class SendController extends Controller implements SendControllerInterface
{
    
    private $sendsRepository;  
    private $sendService;
    private $usersAuthRepository;
    
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(SendsRepository $sendsRepository, SendService $sendService, UsersAuthRepository $usersAuthRepository)
    {
        $this->sendsRepository      = $sendsRepository;
        $this->sendService          = $sendService;
        $this->usersAuthRepository  = $usersAuthRepository;
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

        /* Делаем отправку по каждому каналу и для всех контактов */
        $result = [];
        foreach($channels as $channel => $contactsType) {

            /* Список контактных данных под ключам типа контактных данных */
            $contactsDataByType = $contactsData[$contactsType];

            /* Отправляем всем, кто в списке */
            foreach($contactsDataByType as $contact) {
                $result[] = $this->sendService->send($template, $channel, $contact, $data);
            }
            
        }

        return response($result, 200);
    }

    /**
     * API send
     */
    public function sendAPI(Request $request)
    {
        
        $token = $request['token'];
        $auth = $this->usersAuthRepository->validate($token);
        
        if($auth != false) {
            
            $type       = $request['type'];
            $channel    = $request['channel'];
            $contact    = $request['contact'];
            $data       = json_decode($request['data'], true);

            $result = $this->sendService->send($type, $channel, $contact, $data, $auth['user_id']);
            return response($result, 200);

        }
        return response('the token is not valid', 403);
    }

    /**
     * API resendAPI
     */
    public function resendAPI(Request $request)
    {
        
        $token = $request['token'];
        $auth = $this->usersAuthRepository->validate($token);
        
        if($auth != false) {
            
            $sendId = (int)$request['send_id'];

            $result = $this->sendService->resend($sendId, $auth['user_id']);
            return response($result, 200);

        }
        return response('the token is not valid', 403);
    }

}
