<?php

namespace App\Http\Interfaces;
use Illuminate\Http\Request;

interface SendControllerInterface
{

    /**
     * Show all user's sends
     *
     */
    public function index();

    /**
     * Show send by ID
     */
    public function get($id);

    /**
     * Multiple Sending
     */
    public function create(Request $request);

    /**
     * Send
     */
    public function send($type, $channel, $contact, $data);

    /**
     * Send status
     */
    public function status($id);

}