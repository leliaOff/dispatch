<?php

namespace App\Http\Interfaces;
use Illuminate\Http\Request;

/**
 * Интерфейс отправлений
 */
interface DispatchServiceInterface
{

    /**
     * Отправить сообщение
     *
     */
    public function send($contact, $text);

    /**
     * Получить статус сообщения
     */
    public function getStatus($id);

}