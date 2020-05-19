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
        //переместить в отправленные
        $letter = Letter::find($data['letterId']);
        $letter->draft = 0;
        $letter->sending = 1;
        $letter->to = $data['to'];
        $letter->subject = $data['subject'];
        $letter->save();

        $emailData = new \stdClass();
        $emailData->to = $data['to'];
        $emailData->subjcet = $data['subject'];
        $emailData->body = $data['editorData'];
        $emailData->attach = $data['attach'];
        Mail::to($emailData->to)->queue(new SentEmail($emailData));

        return response()->json('ok' , 200);
    }

}
