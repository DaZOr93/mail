<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folders;
use App\Models\Letter;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


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
        return response()->json($message = $this->messageService->show($uid), 200);
    }

    /**
     * Удалить сообщение
     *
     * @param $uid
     * @param $message_id
     *
     * @return JsonResponseAlias
     */
    public function delete($uid, $message_id)
    {
      return response()->json($this->messageService->delete($uid, $message_id) , 200);
    }

    /**
     * Обновить письмо
     *
     * @return JsonResponseAlias
     */
    public function update()
    {
        return response()->json($this->messageService->update() , 200);
    }

    /**
     * Сохронить черновик
     *
     * @param Request $request
     *
     * @return JsonResponseAlias
     */
    public function storeDraft(Request $request)
    {
        return response()->json($this->messageService->storeDraft($request), 200);
    }

    /**
     * Обновить черновик
     *
     * @param Request $request
     *
     *
     * @return JsonResponseAlias
     */
    public function updateDraft(Request $request)
    {
        return response()->json($this->messageService->updateDraft($request), 200);
    }

    /**
     * Сообщения в кастомной папке
     *
     * @param $slug
     *
     *
     * @return JsonResponseAlias
     */
    public function folderMess($slug)
    {
        $folder_id = Folders::where('slug', $slug)->first()->id;

        return response()->json(Letter::where('folder_id', $folder_id)->paginate(10), 200);
    }

    /**
     * Подсчитать кол-во сообщений в служебных папок
     *
     * @return JsonResponseAlias
     */
    public function messagesTollsCount()
    {
        return response()->json($this->messageService->messagesTollsCount(), 200);
    }

    /**
     * Скачать вложенность
     *
     * @return BinaryFileResponse
     */
    public function download()
    {
        return response()->download('storage/' . \request()->path, \request()->name);
    }

    /**
     * Добавить в избранное
     *
     * @param $method
     * @param $message_id
     * @param $uid
     *
     * @return JsonResponseAlias
     */
    public function favorite($method, $message_id, $uid)
    {
        return response()->json($this->messageService->favorite($method, $message_id, $uid), 200);
    }

    /**
     * Поиск письмем
     *
     * @param $value
     * @return JsonResponseAlias
     */
    public function search($value)
    {
        return response()->json($this->messageService->search($value), 200);
    }

    /**
     * Получить что искал
     *
     * @param $value
     * @return JsonResponseAlias
     */
    public function getSearch($value)
    {
        return response()->json($this->messageService->getSearch($value), 200);
    }

}
