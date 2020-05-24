<?php

namespace App\Services;

interface AttachmentsServicesInterface
{
    /**
     * Получить вложенности к письму
     * @param $letter_id
     * @return mixed
     */
    public function index($letter_id);

    /**
     * Добавление вложенности
     * @param $request
     * @return array
     */
    public function store($request);

    /**
     * удаление вложенности
     * @param $path
     */
    public function destroy($path);
}
