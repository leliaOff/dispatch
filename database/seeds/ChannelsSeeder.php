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

        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        Channel::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        foreach($channels as $channel) {
            Channel::create($channel);
        }

    }
}
