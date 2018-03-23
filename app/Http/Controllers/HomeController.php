<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Repositories\UsersRepository;

class HomeController extends Controller
{
    
    private $usersRepository;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Login.
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
     * Registration.
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
     * @brief Метод для выхода
     */
    public function logout() {
        Auth::logout();
    }
}
