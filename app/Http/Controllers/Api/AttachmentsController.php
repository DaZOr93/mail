<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAttachmentsRequest;
use App\Services\AttachmentsServices;
use Illuminate\Http\JsonResponse;

class AttachmentsController extends Controller
{
    /**
     * @var AttachmentsServices
     */
    private $service;

    public function __construct(AttachmentsServices $service)
    {
        $this->service = $service;
    }


    /**
     * Показать вложености
     * @param $letter_id
     * @return JsonResponse
     */
    public function index($letter_id)
    {
        return response()->json($this->service->index($letter_id), 200);
    }

    /**
     * Добавить вложенность в сообщения
     * @param StoreAttachmentsRequest $request
     * @return JsonResponse
     */
    public function store(StoreAttachmentsRequest $request)
    {
        return response()->json($this->service->store($request), 200);
    }

    /**
     * Удалиение вложенности из сообщения
     * @param $path
     * @return JsonResponse
     */
    public function delete($path)
    {
        $this->service->delete($path);

        return response()->json('deleted', 200);
    }

}
