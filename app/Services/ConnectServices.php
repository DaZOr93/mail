<?php


namespace App\Services;


use App\Models\Attachments;
use App\Models\Letter;
use Carbon\Carbon;
use Webklex\IMAP\Facades\Client;

class ConnectServices
{
    public function connect($account)
    {
        $oClient = Client::account($account);

        return $oClient->connect();
    }

    public function mainFolder()
    {
        return $this->connect('default')->getFolder("inbox");
    }

    public function store()
    {
        $aMessage = $this->mainFolder()->query()->whereAll()->setFetchFlags(true)->setFetchBody(true)->setFetchAttachment(true)->get();

        foreach ($aMessage as $message) {
            if (Letter::where('message_id', $message->message_id)->first()) {
                continue;
            } else {
                $letter = new Letter();
                $letter->message_id = $message->message_id;
                $letter->uid = $message->uid;
                $letter->date_send = Carbon::make($message->date)->format('Y-m-d H:m:s');
                $letter->to = $message->to[0]->mail;
                $letter->from = $message->from[0]->mail;
                $letter->html = $message->getHTMLBody(true);
                $letter->text = $message->getTextBody(true);
                $letter->to_name = $message->to[0]->personal;
                $letter->from_name = $message->from[0]->personal;
                $letter->subject = $message->getSubject();
                $letter->attach = $message->hasAttachments();
                $letter->favorite = $message->getFlags()['flagged'];
                $letter->save();
                if ($message->hasAttachments()) $this->attach($message, $letter->id);
            }
        }

        return response()->json(Letter::where('inbox', 1)->orderByDesc('date_send')->paginate(10), 200);
    }


    /**
     * Сохронить вложения сообщения
     *
     * @param $data
     * @param $letter_id
     */
    public function attach($data, $letter_id)
    {
        $dataAttachments = $data->getAttachments();

        foreach ($dataAttachments as $attach) {
            $uniq_path = uniqid();
            $BdAttachments = new Attachments();
            $BdAttachments->letter_id = $letter_id;
            $BdAttachments->path = '\app\incoming\\' . $uniq_path .$attach->getName();
            $BdAttachments->mime_type = substr($attach->getName(), strrpos($attach->getName(), '.') + 1);
            $BdAttachments->imageSrc = $attach->getImgSrc();
            $BdAttachments->name = $attach->getName();
            $BdAttachments->save();
            $attach->save(storage_path() .'/app/incoming' ,  $uniq_path .$attach->getName());
        }

    }

    /*
     * фильтр сообщений
    *
    * */
    public function firstOrUpdate()
    {
        $date_send = Letter::select('date_send')->orderByDesc('date_send')->first();

        if ($date_send) {
            $data = explode('-', explode(' ', $date_send->date_send)[0]);
            $data_format = implode(".", array_reverse($data));

            return $this->mainFolder()->query()->SINCE($data_format)->get();
        }

        return $this->mainFolder()->query()->whereAll()->setFetchFlags(true)->setFetchBody(true)->setFetchAttachment(true)->get();
    }
}
