<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\UsersRepository;
use App\Http\Repositories\UsersAuthRepository;
use App\Http\Interfaces\HomeControllerInterface;

class HomeController extends Controller implements HomeControllerInterface
{
    
    private $usersRepository;
    private $usersAuthRepository;
    
    /**
     * Create a new controller instance
     *
     * @return void
     */
    public function __construct(UsersRepository $usersRepository, UsersAuthRepository $usersAuthRepository)
    {
        $this->usersRepository = $usersRepository;
        $this->usersAuthRepository = $usersAuthRepository;
    }

    /**
     * Show the application dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Login
     *
     * @return void
     */
    public function login(Request $request)
    {
        
        if(!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return response('incorrect', 401);
        }

        $user   = Auth::user();
        $id     = Auth::id();

        return response('success', 200);
    }

    /**
     * Registration
     *
     * @return void
     */
    public function registration(Request $request)
    {

        $this->validate($request, [
            'email'     => 'required|string|email|max:255|unique:users',
            'password'  => 'required|string|min:6|confirmed',
            'name'      => 'required|string|min:6|max:255',
        ]);

        $data = [
            'name'      => $request['name'],
            'email'     => $request['email'],
            'password'  => bcrypt($request['password']),
        ];

        $this->usersRepository->create($data);
        return response('success', 200);
     }

    /**
     * Exit
     */
    public function logout()
    {
        Auth::logout();
    }

    /**
     * API Login
     */
    public function loginAPI(Request $request)
    {
        
        if(!Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            return response('incorrect', 403);
        }

        //auth's token
        $token = $this->usersAuthRepository->create();

        return response($token, 200);
    }

    /**
     * API valid token
     */
    public function tokenAPI(Request $request)
    {
        $token = $request['token'];
        if(!$this->usersAuthRepository->validate($token)) {
            return response('fail', 403);
        }
        return response('success', 200);
    }

    /**
     * API Logout
     */
    public function logoutAPI(Request $request)
    {
        
        $token = $request['token'];
        if(!$this->usersAuthRepository->validate($token)) {
            return response('the token is not valid', 403);
        }

        $this->usersAuthRepository->delete($token);
        
        return response('success', 200);
    }
}
