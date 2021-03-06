<?php


namespace App\Services;


use App\Models\Attachments;
use App\Models\Folders;
use App\Models\Letter;
use App\Models\Pickers;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Webklex\IMAP\Client;
use Webklex\IMAP\Exceptions\ConnectionFailedException;
use Webklex\IMAP\Exceptions\MaskNotFoundException;

class ConnectServices
{

    public $folder_id;

    /**
     * Подключение к аккануту
     * @param $account
     * @return mixed
     * @throws MaskNotFoundException
     * @throws ConnectionFailedException
     */
    public function connect($account)
    {
        $oClient = new Client([
            'host' => 'imap.gmail.com',
            'port' => $account->port,
            'encryption' => 'ssl',
            'validate_cert' => true,
            'username' => $account->email,
            'password' => $account->password,
            'protocol' => $account->driver
        ]);

        return $oClient->connect();
    }

    /**
     * Получение главной папки
     * @param $folder
     * @return mixed
     * @throws ConnectionFailedException
     * @throws MaskNotFoundException
     */
    public function mainFolder($folder)
    {

        $user_id = Auth::user()->id;
        $folder = Folders::where('name', $folder)->first();

        if ($folder && $folder->pickers === 1) {
            $account = Pickers::where('user_id', $user_id)->where('email', $folder->name)->first();
            $this->folder_id = $folder->id;
        } else {
            $account = Pickers::where('user_id', $user_id)->whereNull('folder_name')->first();
        }

        return $this->connect($account)->getFolder("inbox");
    }

    /**
     * Подгрузка сообщений в бд
     * @param $folder
     * @return JsonResponse
     * @throws ConnectionFailedException
     * @throws MaskNotFoundException
     */
    public function store($folder)
    {
        $aMessage = $this->mainFolder($folder)->query()->whereAll()->setFetchFlags(true)->setFetchBody(true)->setFetchAttachment(true)->get();
        $user_id = Auth::user()->id;
        foreach ($aMessage as $message) {
            if (Letter::where('message_id', $message->message_id)->first()) {
                continue;
            } else {
                $letter = new Letter();
                $letter->message_id = $message->message_id;
                $letter->user_id = $user_id;
                $letter->folder_id = $this->folder_id ?? null;
                $letter->uid = $message->uid;
                $letter->date_send = Carbon::make($message->date)->timezone('Europe/Kiev')->format('Y-m-d H:i:s');
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
            $BdAttachments->path = '/app/incoming/' . $uniq_path . $attach->getName();
            $BdAttachments->mime_type = substr($attach->getName(), strrpos($attach->getName(), '.') + 1);
            $BdAttachments->imageSrc = $attach->getImgSrc();
            $BdAttachments->name = $attach->getName();
            $BdAttachments->save();
            $attach->save(storage_path() . '/app/incoming', $uniq_path . $attach->getName());
        }

    }

    /**
     * Получить сообщения из ящика с офсеттом
     * @return mixed
     * @throws MaskNotFoundException
     * @throws ConnectionFailedException
     */
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
