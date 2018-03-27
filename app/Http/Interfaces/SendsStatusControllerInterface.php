<?php

namespace App\Http\Interfaces;
use Illuminate\Http\Request;

interface SendsStatusControllerInterface
{

    /**
     * Get all statuses
     */
    public function allAPI(Request $request);
    
    /**
     * Get last status
     *
     */
    public function findAPI(Request $request);

}