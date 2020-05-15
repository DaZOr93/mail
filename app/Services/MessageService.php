<?php


namespace App\Services;

use App\Models\Letter;
use Webklex\IMAP\Facades\Client;

class MessageService
{
    /**
     * Получить все письма
     * @param $offset
     *
     * @return mixed
     */
    public function index($offset = 1)
    {
        $oFolder = $this->getFolder('inbox' , 'default');
        $data['messages'] = $oFolder->getMessages('ALL', false, true, true, true, 10, $offset);
        $data['attr'] = $this->getAttribute($data['messages']);
        $data['pagination'] = $this->paginate($oFolder, $data['messages'], $offset);
        $data['pagination']['page'] = $offset;

        return $data;
    }

    /**
     * Получить посьмо по uid
     *
     * @param $uid
     *
     * @return mixed
     */
    public function show($uid)
    {
        $oFolder = $this->getFolder('inbox' , 'default');

        $data['messages'] = $oFolder->getMessage($uid, false, false, true, true);
        $data['attr'] = $data['messages']->getAttributes();

        return $data;
    }

    public function delete($uid)
    {
        $this->getFolder('inbox' , 'default')->
        getMessage($uid, false, false, false, false)->delete();

    }
    /**
     * перейти в служебную папку
     *
     * @param $folder_name
     * @param $offset
     *
     * @return mixed
     */
    public function filters($folder_name , $offset)
    {
        $oFolder = $this->connect('default')->getFolder("[Gmail]/{$folder_name}");

        //dd($this->connect('default')->getFolder('[Gmail]/&BB4EQgQ,BEAEMAQyBDsENQQ9BD0ESwQ1-')->getMessages());
        $data['messages'] = $oFolder->getMessages('ALL', false, true, true, true, 10, $offset);
        $data['attr'] = $this->getAttribute($data['messages']);
        $data['pagination'] = $this->paginate($oFolder, $data['messages'], $offset);
        $data['pagination']['page'] = $offset;

        return $data;
    }

    /**
     * Получить атрибуты письма
     *
     * @param $messages
     * @return array
     */
    public function getAttribute($messages)
    {
        $attrMes = [];

        foreach ($messages as $message) {
            $attrMes[] = $message->getAttributes();
        }

        return $attrMes;
    }


    /**
     * Пагинация
     *
     * @param $folder
     * @param $messages
     * @param $offset
     *
     * @return array
     */
    public function paginate($folder, $messages, $offset)
    {
        $attr = [];
        $attr['total'] = $folder->getMessages('ALL', false, false, false, false)->count();
        $attr['current'] = $messages->count();

        $attr['start'] = $offset - 1 . '0';

        if ($attr['current'] < 10) {
            $attr['end'] = $attr['total'];
        } else {
            $attr['end'] = $offset . '0';
        }

        $attr['start'] = (integer)$attr['start'] + 1;

        return $attr;
    }

    /**
     * Подключение к почте
     *
     * @param $account
     * @return mixed
     */
    public function connect($account)
    {
        $oClient = Client::account($account);

        return $oClient->connect();
    }

    /**
     * Открыть папку
     * @param $name
     * @param $account
     *
     * @return mixed
     */
    public function getFolder($name , $account)
    {
        return $this->connect($account)->getFolder($name);
    }


//    public function store()
//    {
//        $data = $this->connect('default')->getMessages('ALL', false, true, true, true);
//
//        foreach ($data as $message) {
//            $letter = new Letter();
//            $letter->user_id = 1;
//            $letter->folder_id = null;
//            $letter->date_create = $message->getDate();
//            $letter->date_send = $message->getDate();
//            $letter->deleted_ad = $message->getDate();
//            $letter->to = 'мне';
//            $letter->from = $message->getFrom()[0]->mail;
//            $letter->subject = $message->getSubject();
//            $letter->body = $message->getHTMLBody(true);
//            $letter->seen = 0;
//            $letter->save();
//        }
//    }
}
