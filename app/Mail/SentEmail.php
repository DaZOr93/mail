<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SentEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $email;

    /**
     * Create a new message instance.
     * @param $email
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('email')->subject($this->email->subjcet)->from($this->email->to);

        foreach ($this->email->attach as $attach) {
            $email->attach('storage/app/' . $attach['path'] , [
                'as' => $attach['name']
            ]);
        }

        return $email;
    }
}
