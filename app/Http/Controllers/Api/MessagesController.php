<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folders;
use App\Models\Letter;
use App\Services\MessageService;
use Illuminate\Support\Facades\Request;
use Illuminate\Http\JsonResponse as JsonResponseAlias;


class MessagesController extends Controller
{
    private $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @param $servicesFolder служебная папка
     *
     * @return JsonResponseAlias
     */
    public function index($servicesFolder)
    {
        return response()->json($this->messageService->index($servicesFolder), 200);
    }

    /**
     * Показать сообщение по uid
     *
     * @param $uid
     *
     * @return JsonResponseAlias
     */
    public function show($uid)
    {
        return $message = $this->messageService->show($uid);
    }


    /**
     * Удалить сообщение
     *
     * @param $uid
     *
     * @param $message_id
     */
    public function delete($uid , $message_id)
    {
        $this->messageService->delete($uid, $message_id);
    }

    public function update()
    {
        $this->messageService->update();
    }

    public function folderMess($slug)
    {
        $folder_id = Folders::where('slug', $slug)->first()->id;

        return response()->json(Letter::where('folder_id', $folder_id)->paginate(10), 200);
    }

    public function messagesTollsCount()
    {
        return response()->json($this->messageService->messagesTollsCount() , 200);
    }





}
