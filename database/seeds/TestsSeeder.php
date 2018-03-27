<?php


use App\User;
use App\Models\Send;
use App\Models\Template;
use App\Models\UsersAuth;
use App\Models\SendsStatus;
use Illuminate\Database\Seeder;

class TestsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=TestsSeeder
     * @return void
     */
    public function run()
    {
        
        /* Truncate */

        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        
        UsersAuth::truncate();
        SendsStatus::truncate();
        Send::truncate();
        Template::truncate();
        User::truncate();

        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');
        
        /* User */
        
        $data = ['email' => 'leliaoff@ya.ru', 'password' => bcrypt('1q2w3e4r'), 'name' => 'Алёна Игоревна'];

        $user = User::create($data);

        /* Templates */

        $data = [
            [ 'user_id' => $user->id, 'title' => 'Регистрация', 'alias' => 'register', 'text' => 'Спасибо за регистрацию, товарищ {username}!' ],
            [ 'user_id' => $user->id, 'title' => 'Скидки', 'alias' => 'sale', 'text' => 'Товарищ {username}! У нас большие скидки, до {sale}%! Торопитесь!' ],
        ];

        foreach($data as $value) {
            Template::create($value);
        }

    }
}
