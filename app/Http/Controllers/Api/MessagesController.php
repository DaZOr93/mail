<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse as JsonResponseAlias;

class MessagesController extends Controller
{
    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @param $offset
     *
     * @return JsonResponseAlias
     */
    public function index($offset)
    {
        $messages = $this->messageService->index($offset);

        return response()->json($messages);
    }

    /**
     * @param $uid
     *
     * @return JsonResponseAlias
     */
    public function show($uid)
    {
        $message = $this->messageService->show($uid);

        return response()->json($message);
    }

    public function filters($filter , $offset)
    {
       return $messages = $this->messageService->filters($filter , $offset );
    }


//
//    public function store()
//    {
//        $this->messageService->store();
//
//        return response()->json('2222');
//    }

}
