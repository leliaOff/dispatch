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
     * Send for API
     */
    public function sendAPI(Request $request);

    /**
     * Resend for API
     */
    public function resendAPI(Request $request);

}