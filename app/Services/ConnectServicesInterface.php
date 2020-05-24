<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

interface ConnectServicesInterface
{
    /**
     * Подключение к аккануту
     * @param $account
     * @return mixed
     */
    public function connect($account);

    /**
     * Получение главной папки
     * @return mixed
     */
    public function mainFolder();

    /**
     * Подгрузка сообщений в бд
     * @return JsonResponse
     */
    public function store();

    /**
     * Сохронить вложения сообщения
     * @param $data
     * @param $letter_id
     */
    public function attach($data, $letter_id);

    /**
     * Получить сообщения из ящика с офсеттом
     * @return mixed
     */
    public function firstOrUpdate();
}
