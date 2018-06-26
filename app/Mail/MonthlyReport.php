<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\User;



class MonthlyReport extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function setUser( $user ){
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;

        return $this->from('vittalecas@clinicavittagoiania.com.br')
                ->view('emails.send')
                ->subject("Vamos falar das Vittalecas?")
                ->with([
                        'title'     => "Vamos falar das Vittalecas?",
                        'content'   => "Vittalecas",
                        'user'      => $user
                ]);

        /*
        $title = "Título";
        $content = "Conteúdo";
        $attach = null;
        $address = "gabrieldesousa.h@gmail.com";
        $name = "Gabriel";
        $subject = "Teste de assunto";
        $level = 9;
        $pathToFile = null;
        //$options = [];
        $options = null;
        */
    }
}
