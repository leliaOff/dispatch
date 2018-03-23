<?php

namespace App\Http\Interfaces;
use Illuminate\Http\Request;

interface HomeControllerInterface
{

    /**
     * Show the application dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index();

    /**
     * Login
     *
     * @return void
     */
    public function login(Request $request);

    /**
     * Registration
     *
     * @return void
     */
    public function registration(Request $request);

    /**
     * Exit
     */
    public function logout();

}