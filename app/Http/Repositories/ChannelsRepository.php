<?php

namespace App\Http\Repositories;

use App\Models\Channel;

class ChannelsRepository extends BaseRepository 
{
    
    public function __construct(Channel $model) 
    {
        $this->model = $model;
    }

    /**
     * Get all channels
     */
    public function all() 
    {
        return $this->model;
    }

    /**
     * Get channel by ID
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create new channel
     */
    public function create($data) 
    {
        $model = $this->model();
        $item = (new $model())->create($data);

        return $item;
    }

    /**
     * Update channel
     */
    public function update($id, $data)
    {
        $item = $this->model->find($id);    
        $item->fill($data);        
        $item->save();

        return $item;
    }

    /**
     * Delete channel
     */
    public function delete($id)
    {
        $this->model->find($id)->delete();
    }

}