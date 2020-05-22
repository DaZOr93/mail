<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BasketMessageService;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Webklex\IMAP\Client;
class BasketController extends Controller
{
    private $messageService;

    public function __construct(BasketMessageService $messageService)
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
    public function flags()
    {
        $oClient = new Client([
            'host'          => 'imap.gmail.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,
            'username'      => 'it2.0team3@gmail.com',
            'password'      => 'hedbv2580',
            'protocol'      => 'imap'
        ]);
        function truncate_string($str, $maxsymbol){
            if (mb_strlen($str) > $maxsymbol){
                $str=mb_substr($str, 0, $maxsymbol).'...' ;
            }
            return $str;

        }

        $oClient->connect();
        $aFolder = $oClient->getFolder('INBOX');
        $aMessage = $aFolder->messages()->all()
            ->setFetchFlags(true)
            ->setFetchBody(false)
            ->setFetchAttachment(false)
            ->get()->paginate('10');


        foreach($aMessage as $oMessage){
            dd($oMessage->getFlags()['flagged']);

            $mails[] =[
                'subject'=>truncate_string($oMessage->getSubject(), 12),
                'sender'=>truncate_string($oMessage->getSender()[0]->personal, 12),
                'date'=>$oMessage->GetDate()->toDateString(),

            ];
        }

        return response()->json($mails, 200);


    }


}
