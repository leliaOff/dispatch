<?php

namespace App\Http\Interfaces;
use Illuminate\Http\Request;

interface ChannelControllerInterface
{

    /**
     * Show all channels
     *
     */
    public function index();

    /**
     * Show channel by ID
     */
    public function get($id);

    /**
     * Create
     */
    public function create(Request $request);

    /**
     * Update channel
     */
    public function update($id, Request $request);

    /**
     * Delete channel
     */
    public function delete($id);

}