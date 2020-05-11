<?php


namespace App\Services;

use App\Models\Letter;
use Webklex\IMAP\Facades\Client;

class MessageService implements MessageServiceInterface
{
    /**
     * Вся почта
     *
     * @return mixed
     */
    public function index()
    {
        $oClient = $this->connect('default');
        $oFolder = $oClient->getFolder('inbox');

        $data['messages'] = $oFolder->getMessages('ALL' , false , false , true , true , 10 , 1);
        $data['attr'] = $this->getAttribute($data['messages']);

        return $data;
    }

    /**
     * @param $uid
     *
     * @return mixed
     */
    public function show($uid)
    {
        $oClient = $this->connect('default');
        $oFolder = $oClient->getFolder('inbox');

        $data['messages'] = $oFolder->getMessage($uid , false , false , true , true);
        $data['attr'] =  $data['messages']->getAttributes();

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
}
