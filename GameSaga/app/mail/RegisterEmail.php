<?php

namespace App\Mail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterEmail extends Mailable
{
    use Queueable,SerializesModels;
    public function __construct(
        public User $user,
    ){}

    public function build(){
        return $this->subject('welcome')->view('email-register',['user'=>$this->user]);
    }
}