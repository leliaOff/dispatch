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
     * Get all channels
     */
    public function all() 
    {
        return $this->model->where('user_id', Auth::id())->with('template')->with('channel')->with('statuses');
    }

    /**
     * Get channel by ID
     */
    public function find($id)
    {
        return $this->model->where('user_id', Auth::id())->with('template')->with('channel')->with('statuses')->find($id);
    }

    /**
     * Create new channel
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

    // /**
    //  * Update channel
    //  */
    // public function update($id, $data)
    // {
    //     $item = $this->find($id);    
    //     $item->fill($data);        
    //     $item->save();

    //     return $item;
    // }

    // /**
    //  * Delete channel
    //  */
    // public function delete($id)
    // {
    //     $this->model->find($id)->delete();
    // }

}