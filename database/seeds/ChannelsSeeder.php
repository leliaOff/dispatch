<?php

use App\Models\Channel;
use Illuminate\Database\Seeder;

class ChannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=ChannelsSeeder
     * @return void
     */
    public function run()
    {
        $channels = [
            ['name' => 'sms',       'title' => 'SMS'],
            ['name' => 'email',     'title' => 'Email'],
            ['name' => 'telegram',  'title' => 'Telegram'],
        ];

        Channel::truncate();

        foreach($channels as $channel) {
            Channel::create($channel);
        }

    }
}
