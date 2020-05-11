<?php


namespace App\Services;

use App\Models\Letter;
use Webklex\IMAP\Facades\Client;

class MessageService implements MessageServiceInterface
{
    public function index()
    {
        $oClient = Client::account('default');
        $oClient->connect();

        $oFolder = $oClient->getFolder('inbox');
        $data['messages'] = $oFolder->query()->limit(10)->get();
        $data['attr'] = $this->getAttribute($data['messages']);

        return $data;
    }

    public function getAttribute($messages)
    {
        $attrMes = [];

        foreach ($messages  as $message) {
            $attrMes[] =  $message->getAttributes();
        }

        return $attrMes;
    }
}
