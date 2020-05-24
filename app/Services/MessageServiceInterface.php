<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

interface MessageServiceInterface
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

    /**
     * Получить сервисные папки
     * @param $servicesFolder
     * @return mixed
     */
    public function index($servicesFolder);

    /**
     * Показать конкретное пиьсмо
     * @param $message_id
     * @return mixed
     */
    public function show($message_id);

    /**
     * Действие с письмом
     * @param $action
     * @return mixed
     */
    public function update($action);

    /**
     * Подсчитвать количество сообщений в папках
     * @return mixed
     */
    public function messagesTollsCount();

    /**
     * Удалить пиьмо
     * @param $uid
     * @param $message_id
     * @return mixed
     */
    public function delete($uid, $message_id);

    /**
     * Добавить в избранное
     * @param $method
     * @param $message_id
     * @return mixed
     */
    public function favorite($method, $message_id);

    /**
     * создать черновик
     * @param $request
     * @return mixed
     */
    public function storeDraft($request);

    /**
     * обновить черновик
     * @param $request
     * @return mixed
     */
    public function updateDraft($request);

    /**
     * Поиск по содержимому
     * @param $value
     * @return mixed
     */
    public function search($value);

    /**
     * Удаление вложенностей с сообщения
     * @param $attachments
     * @param $letter_id
     * @return mixed
     */
    public function deleteAttach($attachments, $letter_id);
}
