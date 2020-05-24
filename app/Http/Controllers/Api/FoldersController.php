<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FolderServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class FoldersController extends Controller
{
    /**
     * @var FolderServices
     */
    private $folderServices;

    /**
     * FoldersController constructor.
     * @param FolderServices $folderServices
     */
    public function __construct(FolderServices $folderServices)
    {
        $this->folderServices = $folderServices;
    }

    /**
     * Получить все папки
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json($this->folderServices->index(), 200);
    }


    /**
     * Получить папки для настроек
     * @param $limit
     * @return JsonResponse
     */
    public function getForSettings($limit)
    {
        return response()->json($this->folderServices->getForSettings($limit), 200);
    }


    /**
     * Редактирлвать папку
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {
        return response()->json($this->folderServices->update($request), 200);
    }

    /**
     * Удалить папку
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request)
    {
        return response()->json($this->folderServices->delete($request), 200);
    }

    /**
     * Удалить папку
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json($this->folderServices->store($request), 200);
    }
}
