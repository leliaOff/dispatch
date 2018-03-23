<?php

namespace App\Http\Repositories;

use App\Models\Send;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\SendsStatusesRepository;

class SendsRepository extends BaseRepository 
{
    
    private $statusesRepository; 
    
    public function __construct(Send $model, SendsStatusesRepository $statusesRepository) 
    {
        $this->model = $model;
        $this->statusesRepository = $statusesRepository;
    }

    /**
     * Get all sends
     */
    public function all() 
    {
        return $this->model->where('user_id', Auth::id())->with('template')->with('channel')->with('statuses');
    }

    /**
     * Get send by ID
     */
    public function find($id)
    {
        return $this->model->where('user_id', Auth::id())->with('template')->with('channel')->with('statuses')->find($id);
    }

    /**
     * Create new send
     */
    public function create($data) 
    {
        $data['user_id'] = Auth::id();
       
        $model = $this->model();
        $item = (new $model())->create($data);

        //Send's status
        $this->statusesRepository->create($item->id);

        return $item;
    }

}