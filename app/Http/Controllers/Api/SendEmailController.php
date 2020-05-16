<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendRequest;
use App\Mail\SentEmail;
use App\Services\SendEmailService;


class SendEmailController extends Controller
{
    protected $sendService;

    public function __construct(SendEmailService $sendService)
    {
        $this->sendService = $sendService;
    }

    public function index(SendRequest $request)
    {
        $data = $request->validated();

        return $this->sendService->send($data);
    }
}
