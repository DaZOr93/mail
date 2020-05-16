<?php


namespace App\Services;

use App\Models\Letter;

class MessageService extends ConnectServices
{
    /**
     * Получить  письма
     *
     * @param $servicesFolder
     *
     * @return mixed
     */
    public function index($servicesFolder)
    {
        return Letter::where($servicesFolder, 1)->orderByDesc('date_send')->paginate(10);
    }

    /**
     * Получить посьмо по uid
     *
     * @param $message_id
     *
     * @return mixed
     */
    public function show($message_id)
    {
        $letter = Letter::where('message_id', $message_id)->first();
        $letter->update(['seen' => 0]);

        return response()->json($letter , 202);
    }

    /**
     * Удалить пиьсмо
     *
     * @param $uid
     *
     * @param $message_id
     */
    public function delete($uid , $message_id)
    {
        Letter::where('message_id', $message_id)->first()->delete();
        $this->mainFolder()->getMessage($uid, false, false, false, false)->delete();
    }
}
