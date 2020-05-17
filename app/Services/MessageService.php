<?php


namespace App\Services;

use App\Models\Folders;
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

    public function update()
    {
        $data = request()->only('body.slug' , 'body.messages');
        $folder_id = Folders::where('slug' , $data['body']['slug'])->first()->id;

        foreach ($data['body']['messages'] as $message){
            $letter = Letter::where('message_id' , $message['message_id'])->first();
            $letter->folder_id = $folder_id;
            $letter->save();
        }

    }


    /**
     * Кол-во писем в служебных папок
     *
     * @return array $data
     */
    public function messagesTollsCount()
    {
        $data = [];
        $data['inbox'] = Letter::where('inbox' , 1)->count();
        $data['draft'] = Letter::where('draft' , 1)->count();
        $data['sending'] = Letter::where('sending' , 1)->count();
        $data['deleted'] = Letter::where('deleted' , 1)->count();

        return $data;
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

    /**
     * Избранное
     *
     * @param $method
     *
     * @param $message_id
     *
     * @param $uid
     */
    public function favorite($method, $message_id, $uid)
    {

        $letter = Letter::where('message_id', $message_id)->first();

        if($method == 'add'){
            $letter->favorite = 1;
            $this->mainFolder()->getMessage($uid, false, false, false, false)->setFlag('flagged');
        }
        if($method == 'remove'){
            $letter->favorite = 0;
            $this->mainFolder()->getMessage($uid, false, false, false, false)->unsetFlag('flagged');
        }

        $letter->save();

    }
}
