<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $objet;
    public $content;

    public function __construct(array $data)
    {
        $this->objet = $data['objet'];
        $this->content = $data['content'];
    }

    public function build()
    {
        return $this->view('emails.contact')
                    ->with([
                        'objet' => $this->objet,
                        'content' => $this->content
                    ]);
    }
}