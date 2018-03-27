<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Services\StatusesService;

class StatusesServiceTest extends TestCase
{

    const STATUSES = [
        [ 'id' => 1, 'alias' => 'created',          'title' => 'Создано' ],
        [ 'id' => 2, 'alias' => 'send',             'title' => 'Отправлено' ],
        [ 'id' => 3, 'alias' => 'received',         'title' => 'Доставлено' ],
        [ 'id' => 4, 'alias' => 'read',             'title' => 'Прочитано' ],
        [ 'id' => 5, 'alias' => 'send_failed',      'title' => 'Ошибка отправки' ],
        [ 'id' => 6, 'alias' => 'receive_failed',   'title' => 'Ошибка доставки' ],
    ];

    const STATUSNULL = [ 'id' => 0, 'alias' => '', 'title' => '' ];
    
    /**
     * Возвращаем статус по ИД
     */
    public function testGetStatusById()
    {
        $statusesService = new StatusesService();
        
        $result = true;
        foreach(self::STATUSES as $item) {
            $status =  $statusesService->getStatusById($item['id']);
            if($status != $item) $result = false;
        }

        //status null
        $status =  $statusesService->getStatusById(0);
        if($status != self::STATUSNULL) $result = false;
        
        $this->assertTrue($result);
    }

    /**
     * Возвращаем статус по алиасу
     */
    public function testGetStatusByAlias()
    {
        $statusesService = new StatusesService();
        
        $result = true;
        foreach(self::STATUSES as $item) {
            $status =  $statusesService->getStatusByAlias($item['alias']);
            if($status != $item) $result = false;
        }

        //status null
        $status =  $statusesService->getStatusByAlias('');
        if($status != self::STATUSNULL) $result = false;
        
        $this->assertTrue($result);

    }
    
}
