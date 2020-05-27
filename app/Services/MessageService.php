<?php


namespace App\Services;

use App\Models\Attachments;
use App\Models\Folders;
use App\Models\Letter;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class MessageService extends ConnectServices
{

    public function index($servicesFolder)
    {
        $user_id = Auth::user()->id;
        if($servicesFolder === 'draft') {
            return Letter::where($servicesFolder, 1)
                ->with('attachments')
                ->where('user_id' , $user_id)
                ->whereNull('folder_id')
                ->orderByDesc('date_send')
                ->paginate(10);
        }

        return Letter::where($servicesFolder, 1)
            ->orderByDesc('date_send')
            ->where('user_id' , $user_id)
            ->whereNull('folder_id')
            ->paginate(10);

    }

    public function show($message_id)
    {
        $letter = Letter::where('message_id', $message_id)->with('attachments')->first();
        $letter->update(['seen' => 0]);

        return $letter;
    }

    public function update($action)
    {
        $data = request()->only('body.slug', 'body.messages', 'body.action');
        if ($action == 'folder') $folder_id = Folders::where('slug', $data['body']['slug'])->first()->id;

        foreach ($data['body']['messages'] as $message) {
            $letter = Letter::where('message_id', $message['message_id'])->first();

            if (isset($folder_id)) {
                $letter->folder_id = $folder_id;
            } else if ($action == 'seen') {
                $letter->$action = !$letter->getOriginal($action);
            } else {
                $letter->$action = !$letter->getOriginal($action);
                $letter->inbox = 0;
                if (!$letter->$action) $letter->inbox = 1;
                $letter->draft = 0;
                $letter->sending = 0;
            }

            $letter->save();
        }

        return;
    }


    public function messagesTollsCount()
    {
        $data = [];
        $data['inbox'] = Letter::where('inbox', 1)->where('seen', 1)->count();
        $data['draft'] = Letter::where('draft', 1)->count();
        $data['sending'] = Letter::where('sending', 1)->count();
        $data['deleted'] = Letter::where('deleted', 1)->count();
        $data['spam'] = Letter::where('spam', 1)->count();

        return $data;
    }

    public function delete($uid, $message_id)
    {
        $letter = Letter::where('message_id', $message_id)->with('attachments')->first();
        if ($letter->deleted == 1) {
            if ($letter->attachments) $this->deleteAttach($letter->attachments, $letter->id);
            $letter->delete();
        } else {
            $letter->sending = 0;
            $letter->inbox = 0;
            $letter->draft = 0;
            $letter->deleted = 1;
            $letter->save();
            $this->mainFolder()->getMessage($uid, false, false, false, false)->delete();
        }

    }

    public function favorite($method, $message_id)
    {

        $letter = Letter::where('message_id', $message_id)->first();

        if ($method == 'add') {
            $letter->favorite = 1;
        }
        if ($method == 'remove') {
            $letter->favorite = 0;
        }

        $letter->save();

    }

    public function storeDraft($request)
    {
        $user_id = Auth::user()->id;
        $data = $request->only(['editorData', 'subject', 'to', 'attach', 'attachBol']);
        $letter = new Letter();
        $letter->message_id = uniqid();
        $letter->user_id = $user_id;
        $letter->uid = rand(1, 200);
        $letter->date_send = Carbon::now('Europe/Kiev')->format('Y-m-d H:i:s');
        $letter->to = $data['to'] ?? '';
        $letter->from = 'it2.0team3@gmail.com';
        $letter->to_name = $data['to'] ?? '';
        $letter->from_name = 'it2.0team3';
        $letter->subject = $data['subject'] ?? '';
        $letter->html = $data['editorData'];
        $letter->text = strip_tags($data['editorData']);
        $letter->draft = 1;
        $letter->inbox = 0;
        $letter->seen = 0;
        $letter->attach = $data['attachBol'];
        $letter->save();

        return $letter->id;
    }

    public function storeDraftIncoming($request)
    {
        $letter = Letter::find($request->id);
        $draftLetter = $letter->replicate();
        $draftLetter->inbox = 0;
        $draftLetter->draft = 1;
        $draftLetter->push();

        return;
    }

    public function updateDraft($request)
    {
        $letter = Letter::find($request->id);
        $letter->html = $request->message['editorData'] ?? '';
        $letter->attach = $request->message['attachBol'];
        $letter->subject = $request->message['subject'] ?? '';
        $letter->to = $request->message['to'] ?? implode(' ' , $request->message['emails']) ?? '';

        return $letter->save();
    }

    public function search($value)
    {
        $user_id = Auth::user()->id;
        return Letter::where('user_id' , $user_id)
            ->where("subject", "like", "%{$value}%")
            ->orWhere("text", "like", "%{$value}%")
            ->get();
    }


    public function deleteAttach($attachments, $letter_id)
    {
        Attachments::where('letter_id', $letter_id)->delete();

        foreach ($attachments as $attach) {
            unlink('storage/' . $attach->path);
        }
    }
}
