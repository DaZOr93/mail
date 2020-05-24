<?php

namespace App\Services;

interface FolderServicesInterface
{
    /**
     * Получить папки
     * @return mixed
     */
    public function index();

    /**
     * Получить папки для настроек
     * @param $limit
     * @return mixed
     */
    public function getForSettings($limit);

    /**
     * редактирование папки
     * @param $request
     * @return mixed
     */
    public function update($request);

    /**
     * Удаление папки
     * @param $request
     * @return mixed
     */
    public function delete($request);

    /**
     * Добавление папки
     * @param $request
     * @return mixed
     */
    public function store($request);
}
