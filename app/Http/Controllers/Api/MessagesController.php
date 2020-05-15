<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Folders;
use App\Models\Letter;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse as JsonResponseAlias;
use Webklex\IMAP\Facades\Client;

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

    public function sending($uid)
    {
        $oClient = Client::account('default');

        $oFolder = $oClient->getFolder("[Gmail]/&BB4EQgQ,BEAEMAQyBDsENQQ9BD0ESwQ1-");

        $data['messages'] = $oFolder->getMessage($uid, false, false, true, true);

        $data['attr'] = $data['messages']->getAttributes();


        return response()->json($data);
    }




    public function filters($filter, $offset)
    {
        return $messages = $this->messageService->filters($filter, $offset);
    }

    public function store()
    {
        $messages  = request()->all();
        $folder = Folders::where('slug',  $messages['body']['slug'])->first();


        foreach ($messages['body']['messages'] as $message) {
            if($letter =  Letter::where('message_id' , $message['message_id'])->first()) {
                $letter->folder_id = $folder->id;
            }else{
                $letter = new Letter();
                $letter->folder_id = $folder->id;
                $letter->message_id = $message['message_id'];
                $letter->uid = $message['uid'];
                $letter->date_send = $message['date'];
                $letter->to = $message['to'][0]['mail'];
                $letter->from = $message['sender'][0]['mail'];
                $letter->subject = $message['subject'] ?? '( без темы )';
                $letter->body = '222';
                $letter->seen = false;
                $letter->favorite = false;
                $letter->save();
            }
        }

        return response()->json('ok' , 200);
    }

    public function folderMess($slug)
    {
        $folder_id = Folders::where('slug' , $slug)->first()->id;

       return response()->json(Letter::where('folder_id' , $folder_id)->get());
    }

}
