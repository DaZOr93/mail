<?php


namespace App\Services;


use App\Mail\SentEmail;
use App\Models\Letter;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;

class SendEmailService
{
    /**
     * @param array $data
     * @return JsonResponse
     */
    public function send(array $data)
    {

        $emailData = new \stdClass();
        $emailData->to = $data['to'] ?? '';
        $emailData->subjcet = $data['subject'];
        $emailData->body = $data['editorData'];
        $emailData->attach = $data['attach'];
        $emailData->emails = $data['emails'] ?? '';

        if (!$emailData->to) {
            foreach ($data['emails'] as $recipient) {
                Mail::to($recipient)->queue(new SentEmail($emailData));
            }
        } else {
            Mail::to($data['to'])->queue(new SentEmail($emailData));
        }


        //пометить письмо как отправленное
        $letter = Letter::find($data['letterId']);
        $letter->draft = 0;
        $letter->sending = 1;
        $letter->to = (!$emailData->to) ? implode(" ", $data['emails']) : $data['to'];
        $letter->subject = $data['subject'] ?? '';
        $letter->html = $data['editorData'] ?? '';
        $letter->attach = (count($data['attach']) > 0) ? 1 : 0;
        $letter->save();

        return response()->json('sending', 200);
    }

}
