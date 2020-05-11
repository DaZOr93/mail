<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MessageService;

class MessagesController extends Controller
{
    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index()
    {
        $messages = $this->messageService->index();

        return response()->json($messages);
    }

    public function show($uid)
    {
        $message = $this->messageService->show($uid);

        return response()->json($message);
    }

}
