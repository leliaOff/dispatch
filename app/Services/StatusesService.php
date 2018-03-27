<?php

namespace App\Services;

class StatusesService
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
    
    public function __construct()
    {
        // ...
    }

    /**
     * Возвращаем статус по ИД
     */
    public function getStatusById($id)
    {
        $items = array_filter(self::STATUSES, function($item) use($id) {
            if($item['id'] == $id) return true;
            return false;
        });

        if(count($items) == 0) return self::STATUSNULL;
        return array_shift($items);
    }

    /**
     * Возвращаем статус по алиасу
     */
    public function getStatusByAlias($alias)
    {
        $items = array_filter(self::STATUSES, function($item) use($alias) {
            if($item['alias'] == $alias) return true;
            return false;
        });

        if(count($items) == 0) return self::STATUSNULL;
        return array_shift($items);

    }

}