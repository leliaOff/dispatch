<?php

namespace App\Http\Repositories;

use App\Models\SendsStatus;

class SendsStatusesRepository extends BaseRepository 
{
    
    public function __construct() 
    {
        $this->model = new SendsStatus();
    }

    private function insert($data)
    {
        $model = $this->model();
        $item = (new $model())->create($data);

        return $item;
    }

    /**
     * Create new send
     */
    public function create($send_id) 
    {
        $data = [
            'send_id'   => $send_id,
            'status_id' => 1
        ];

        return $this->insert($data);
    }

    /**
     * Send message
     */
    public function send($send_id) 
    {
        $data = [
            'send_id'   => $send_id,
            'status_id' => 2
        ];

        return $this->insert($data);
    }

    /**
     * Received message
     */
    public function receive($send_id) 
    {
        $data = [
            'send_id'   => $send_id,
            'status_id' => 3
        ];

        return $this->insert($data);
    }

    /**
     * Read message
     */
    public function read($send_id) 
    {
        $data = [
            'send_id'   => $send_id,
            'status_id' => 4
        ];

        return $this->insert($data);
    }

    /**
     * Send failed
     */
    public function sendFail($send_id) 
    {
        $data = [
            'send_id'   => $send_id,
            'status_id' => 5
        ];

        return $this->insert($data);
    }

    /**
     * Receive failed
     */
    public function receiveFail($send_id) 
    {
        $data = [
            'send_id'   => $send_id,
            'status_id' => 6
        ];

        return $this->insert($data);
    }

}