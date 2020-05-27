<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePickersRequest;
use App\Services\PickersServices;
use Illuminate\Http\JsonResponse;


class PickersController extends Controller
{

    /**
     * @var PickersServices
     */
    protected $pickersServices;

    public function __construct(PickersServices $pickersServices)
    {
        $this->pickersServices = $pickersServices;
    }

    /**
     * Показать сборщик почты
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json($this->pickersServices->index(), 200);
    }

    /**
     * добавить сборщик
     * @param StorePickersRequest $request
     * @return JsonResponse
     */
    public function store(StorePickersRequest $request)
    {
        return response()->json($this->pickersServices->storePickers($request->validated()), 200);
    }

    /**
     * обновить сборщик
     * @param StorePickersRequest $request
     * @return JsonResponse
     */
    public function update(StorePickersRequest $request)
    {
        return response()->json($this->pickersServices->update($request), 200);
    }

    /**
     * проверить подключение
     * @param StorePickersRequest $request
     * @return JsonResponse
     */
    public function check(StorePickersRequest $request)
    {
        return response()->json(($this->pickersServices->check($request->validated())), 200);
    }

    /**
     * удалить сборщик и папку
     * @param StorePickersRequest $request
     * @return JsonResponse
     */
    public function delete(StorePickersRequest $request)
    {
        return response()->json($this->pickersServices->delete($request), 200);
    }
}
