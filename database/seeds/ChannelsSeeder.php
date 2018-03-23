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
            ['name' => 'sms',       'title' => 'SMS',       'contacts_type_id' => 1],
            ['name' => 'email',     'title' => 'Email',     'contacts_type_id' => 2],
            ['name' => 'telegram',  'title' => 'Telegram',  'contacts_type_id' => 1],
        ];

        Channel::truncate();

        foreach($channels as $channel) {
            Channel::create($channel);
        }

    }
}
