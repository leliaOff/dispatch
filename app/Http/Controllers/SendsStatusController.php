<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\SendService;
use App\Services\StatusesService;
use App\Http\Repositories\UsersAuthRepository;
use App\Http\Interfaces\SendsStatusControllerInterface;

class SendsStatusController extends Controller implements SendsStatusControllerInterface
{
    
    private $sendService;
    private $usersAuthRepository;
    
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(SendService $sendService, UsersAuthRepository $usersAuthRepository)
    {
        $this->sendService              = $sendService;
        $this->usersAuthRepository      = $usersAuthRepository;
    }

    /**
     * Get last status
     *
     */
    public function findAPI(Request $request)
    {
        $token = $request['token'];
        $auth = $this->usersAuthRepository->validate($token);
        
        if($auth != false) {
            
            $sendId = (int)$request['send_id'];

            $result = $this->sendService->status($sendId, $auth['user_id']);
            if(empty($result)) {
                return response('last status not found', 403);
            }

            $result['status'] = (new StatusesService())->getStatusById($result['status_id']);
            return response($result, 200);

        }
        return response('the token is not valid', 403);
    }

    /**
     * Get all statuses
     */
    public function allAPI(Request $request)
    {
        $token = $request['token'];
        $auth = $this->usersAuthRepository->validate($token);
        
        if($auth != false) {
            
            $sendId = (int)$request['send_id'];

            $result = $this->sendService->statuses($sendId, $auth['user_id']);
            if(empty($result)) {
                return response('last status not found', 403);
            }

            $result = array_map(function($value) {
                $value['status'] = (new StatusesService())->getStatusById($value['status_id']);
                return $value;
            }, $result);
            return response($result, 200);

        }
        return response('the token is not valid', 403);
    }

}