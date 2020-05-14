<?php


namespace App\Services;


use App\Mail\SentEmail;
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
        $emailData = new \stdClass();
        $emailData->to = $data['to'];
        $emailData->subjcet = $data['subject'];
        $emailData->body = $data['editorData'];

        Mail::to($emailData->to)->send(new SentEmail($emailData));

        return response()->json('ok' , 200);
    }
}
