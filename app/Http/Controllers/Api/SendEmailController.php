<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendRequest;
use App\Services\SendEmailService;
use Illuminate\Http\JsonResponse as JsonResponseAlias;


class SendEmailController extends Controller
{
    protected $sendService;

    public function __construct(SendEmailService $sendService)
    {
        $this->sendService = $sendService;
    }

    /**
     * Отправка сообщения
     * @param SendRequest $request
     * @return JsonResponseAlias
     */
    public function __invoke(SendRequest $request)
    {
        $data = $request->validated();

        return $this->sendService->send($data);
    }
}
