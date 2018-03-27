<?php

namespace App\Http\Repositories;

use DateTime;
use App\Models\UsersAuth;
use Illuminate\Support\Facades\Auth;

class UsersAuthRepository extends BaseRepository 
{
    
    public function __construct(UsersAuth $model) 
    {
        $this->model = $model;
    }

    /**
     * Create new user's auth
     */
    public function create() 
    {
        $data = [
            'user_id'   => Auth::id(),
            'token'     => hash('sha256', time())
        ];
        
        $model = $this->model();
        $item = (new $model())->create($data);

        return $item->token;
    }

    /**
     * Update channel
     */
    public function validate($token)
    {
        //Тухлость ключа
        $dt = (new DateTime())->modify('-1 hour')->format('Y-m-d H:i:s');
        
        $item = $this->model
            ->where('token', $token)
            ->where('created_at', '>', $dt)
            ->first();

        return !empty($item) ? $item : false;
    }

    /**
     * Delete channel
     */
    public function delete($token)
    {
        $this->model->where('token', $token)->delete();
    }

}