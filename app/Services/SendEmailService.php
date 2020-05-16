<?php


namespace App\Services;


use App\Mail\SentEmail;
use App\Models\Letter;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class SendEmailService
{
    /**
     * @param array $data
     *
     * @return JsonResponse
     */
    public function send(array $data)
    {
        $this->store($data);
        $emailData = new \stdClass();
        $emailData->to = $data['to'];
        $emailData->subjcet = $data['subject'];
        $emailData->body = $data['editorData'];
        Mail::to($emailData->to)->send(new SentEmail($emailData));

        return response()->json('ok' , 200);
    }

    public function store($data)
    {
        $letter = new Letter();
        $letter->message_id = uniqid();
        $letter->uid = Letter::select('uid')->orderByDesc('uid')->first()->uid + 1 ?? 1;
        $letter->date_send = date('Y-m-d H:m:s');
        $letter->to = $data['to'];
        $letter->from = 'it2.0team3@gmail.com';
        $letter->to_name = $data['to'];
        $letter->from_name = 'it2.0team3';
        $letter->subject = $data['subject'];
        $letter->html = $data['editorData'];
        $letter->inbox = 0;
        $letter->seen = 0;
        $letter->sending = 1;
        $letter->attach = 0;
        $letter->save();

        return response()->json('ok' , 200);
    }
}
