<?php


use App\Models\ContactsType;
use Illuminate\Database\Seeder;

class ContactsTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=ContactsTypesSeeder
     * @return void
     */
    public function run()
    {
        $contactsTypes = [
            ['id' => 1, 'name' => 'phone',     'title' => 'Телефон'],
            ['id' => 2, 'name' => 'email',     'title' => 'Email'],
        ];

        \DB::statement('SET FOREIGN_KEY_CHECKS = 0');
        ContactsType::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        foreach($contactsTypes as $contactsType) {
            ContactsType::create($contactsType);
        }

    }
}
