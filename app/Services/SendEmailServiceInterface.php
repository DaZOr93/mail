<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;

interface SendEmailServiceInterface
{
    /**
     * Отправка писем
     * @param array $data
     * @return JsonResponse
     */
    public function send(array $data);
}
