<?php


namespace App\Services;

use App\Models\Attachments;
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

//        $oFolder = $this->connect('default');
//        $data['messages'] = $oFolder->getMessages('ALL', false, true, true, true, 10, $offset);
//        $data['attr'] = $this->getAttribute($data['messages']);
//        $data['pagination'] = $this->paginate($oFolder, $data['messages'], $offset);
//        $data['pagination']['page'] = $offset;
//
//        return $data;

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
        $letter = Letter::where('message_id', $message_id)->with('attachments')->first();
        $letter->update(['seen' => 0]);

        return response()->json($letter, 202);
    }

    public function update()
    {
        $data = request()->only('body.slug', 'body.messages');
        $folder_id = Folders::where('slug', $data['body']['slug'])->first()->id;

        foreach ($data['body']['messages'] as $message) {
            $letter = Letter::where('message_id', $message['message_id'])->first();
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
        $data['inbox'] = Letter::where('inbox', 1)->where('seen', 1)->count();
        $data['draft'] = Letter::where('draft', 1)->count();
        $data['sending'] = Letter::where('sending', 1)->count();
        $data['deleted'] = Letter::where('deleted', 1)->count();

        return $data;
    }


    /**
     * Удалить пиьсмо
     *
     * @param $uid
     *
     * @param $message_id
     */

    public function delete($uid, $message_id)
    {
        $letter = Letter::where('message_id', $message_id)->with('attachments')->first();
        if ($letter->attachments) $this->deleteAttach($letter->attachments, $letter->id);
        $letter->delete();
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

        if ($method == 'add') {
            $letter->favorite = 1;
            $this->mainFolder()->getMessage($uid, false, false, false, false)->setFlag('flagged');
        }
        if ($method == 'remove') {
            $letter->favorite = 0;
            $this->mainFolder()->getMessage($uid, false, false, false, false)->unsetFlag('flagged');
        }

        $letter->save();

    }

    public function storeDraft($request)
    {
        $data = $request->only(['editorData', 'subject', 'to']);
        $letter = new Letter();
        $letter->message_id = uniqid();
        $letter->uid = uniqid();
        $letter->date_send = date('Y-m-d H:m:s');
        $letter->to = $data['to'] ?? '';
        $letter->from = 'it2.0team3@gmail.com';
        $letter->to_name = $data['to'] ?? '';
        $letter->from_name = 'it2.0team3';
        $letter->subject = $data['subject'] ?? '';
        $letter->html = $data['editorData'];
        $letter->text = strip_tags($data['editorData']);
        $letter->draft = 1;
        $letter->inbox = 0;
        $letter->seen = 0;
        $letter->attach = 1;
        $letter->save();

        return $letter->id;
    }

    public function search($value)
    {
        return Letter::where("subject" , "like" , "%{$value}%")->orWhere("text" , "like" ,   "%{$value}%")
            ->select('subject' , 'text')
            ->groupBy('subject' , 'text')
            ->get();
    }
    public function getSearch($value)
    {
        return Letter::where("subject" , "like" , "%{$value}%")->orWhere("text" , "like" ,   "%{$value}%")->paginate(10);
    }


    /*
     * Удаления вложеностей
     * */

    public function deleteAttach($attachments, $letter_id)
    {
        Attachments::where('letter_id', $letter_id)->delete();

        foreach ($attachments as $attach) {
            unlink('storage/' . $attach->path);
        }
    }
}
