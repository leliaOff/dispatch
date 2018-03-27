<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Foundation\Testing\DatabaseMigrations;

use App\Models\UsersAuth;

class APIRequestsTest extends TestCase
{    
    // use DatabaseMigrations {
    //     runDatabaseMigrations as baseRunDatabaseMigrations;
    // }

    // public function runDatabaseMigrations()
    // {
    //     $this->baseRunDatabaseMigrations();
    //     $this->artisan('db:seed');
    //     $this->artisan('db:seed', ['--class' => 'TestsSeeder']); 
    // }

    //protected $token;

    public function setUp()
    {
        parent::setUp();
        $this->artisan('db:seed', ['--class' => 'TestsSeeder']); 
    }

    /**
     * Login
     * Request: email, password
     * Return: token
     */
    public function testApiLogin()
    {
        $response = $this->call('POST', 'api/login', ['email' => 'leliaoff@ya.ru', 'password' => '1q2w3e4r']);
        $this->assertEquals(200, $response->status());
    }

    /**
     * Token
     * Request: token
     * Return: fail/success
     */
    public function testApiToken()
    {
        $response = $this->call('POST', 'api/login', ['email' => 'leliaoff@ya.ru', 'password' => '1q2w3e4r']);
        $token = $response->content();
    
        $response = $this->call('POST', 'api/token', ['token' => $token]);
        $this->assertTrue($response->content() == 'success');
    }

    /**
     * Logout
     * Request: token
     */
    public function testApiLogout()
    {
        $response = $this->call('POST', 'api/login', ['email' => 'leliaoff@ya.ru', 'password' => '1q2w3e4r']);
        $token = $response->content();

        $response = $this->call('POST', 'api/logout', ['token' => $token]);
        $this->assertEquals(200, $response->status());
    }

    /**
     * Send
     * Request: token, type, contact, channel, data(json)
     * Return: send_id
     */
    public function testApiSend()
    {
        $response = $this->call('POST', 'api/login', ['email' => 'leliaoff@ya.ru', 'password' => '1q2w3e4r']);
        $token = $response->content();

        $data = [
            'token'     => $token,
            'type'      => 'register',
            'contact'   => '+79606666666',
            'channel'   => 'telegram',
            'data'      => json_encode(['username' => 'Григорий']),
        ];
        $response = $this->call('POST', 'api/send', $data);
        $this->assertTrue($response->content() == 1);
    }

    /**
     * Resend
     * Request: token, send_id
     * Return: send_id
     */
    public function testApiResend()
    {
        $response = $this->call('POST', 'api/login', ['email' => 'leliaoff@ya.ru', 'password' => '1q2w3e4r']);
        $token = $response->content();

        //send
        $data = [
            'token'     => $token,
            'type'      => 'register',
            'contact'   => '+79606666666',
            'channel'   => 'telegram',
            'data'      => json_encode(['username' => 'Григорий']),
        ];
        $response = $this->call('POST', 'api/send', $data);
        $sendId = $response->content();

        //resend
        $response = $this->call('POST', 'api/resend', ['token' => $token, 'send_id' => $sendId]);
        $this->assertTrue($response->content() == $sendId);
    }

    /**
     * Status
     * Request: token, send_id
     * Return: {
     *   "id": status_id, "send_id": send_id, "created_at": datetime, "updated_at": datetime, 
     *   "status_id": status_type_id, "status": { "id": status_type_id, "alias": status_type_alias, "title": status_type_title }
     * }
     */
    public function testApiStatus()
    {
        $response = $this->call('POST', 'api/login', ['email' => 'leliaoff@ya.ru', 'password' => '1q2w3e4r']);
        $token = $response->content();

        //send
        $data = [
            'token'     => $token,
            'type'      => 'register',
            'contact'   => '+79606666666',
            'channel'   => 'telegram',
            'data'      => json_encode(['username' => 'Григорий']),
        ];
        $response = $this->call('POST', 'api/send', $data);
        $sendId = $response->content();

        $response = $this->call('POST', 'api/status', ['token' => $token, 'send_id' => $sendId]);
        $result = json_decode($response->content(), true);
        
        //send: 2 send_fail: 5
        $this->assertTrue(($result['status_id'] == 2 || $result['status_id'] == 5));
    }

    /**
     * Statuses
     * Request: token, send_id
     * Return: [{
     *   "id": status_id, "send_id": send_id, "created_at": datetime, "updated_at": datetime, 
     *   "status_id": status_type_id, "status": { "id": status_type_id, "alias": status_type_alias, "title": status_type_title }
     * }]
     */
    public function testApiStatuses()
    {
        $response = $this->call('POST', 'api/login', ['email' => 'leliaoff@ya.ru', 'password' => '1q2w3e4r']);
        $token = $response->content();

        //send
        $data = [
            'token'     => $token,
            'type'      => 'register',
            'contact'   => '+79606666666',
            'channel'   => 'telegram',
            'data'      => json_encode(['username' => 'Григорий']),
        ];
        $response = $this->call('POST', 'api/send', $data);
        $sendId = $response->content();

        $response = $this->call('POST', 'api/statuses', ['token' => $token, 'send_id' => $sendId]);
        $result = json_decode($response->content(), true);

        foreach($result as $item) {
            if(!in_array($item['status_id'], [1, 2, 5])) {
                $this->assertTrue(false);
            }
        }
        $this->assertTrue(true);
    }
}
