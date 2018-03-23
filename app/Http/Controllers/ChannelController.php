<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Repositories\ChannelsRepository;
use App\Http\Interfaces\ChannelControllerInterface;

class ChannelController extends Controller implements ChannelControllerInterface
{
    
    private $channelsRepository;
    
    /**
     * Create a new controller instance.
     *
     */
    public function __construct(ChannelsRepository $channelsRepository)
    {
        $this->channelsRepository = $channelsRepository;
    }

    /**
     * Show all channels
     *
     */
    public function index()
    {
        return $this->channelsRepository->all()->get()->keyBy('name');
    }

    /**
     * Show channel by ID
     */
    public function get($id)
    {
        return $this->channelsRepository->find($id);
    }

    /**
     * Create
     */
    public function create(Request $request)
    {
        // TODO: доделать
    }

    /**
     * Update channel
     */
    public function update($id, Request $request)
    {
        // TODO: доделать
    }

    /**
     * Delete channel
     */
    public function delete($id)
    {
        // TODO: доделать
    }
}
