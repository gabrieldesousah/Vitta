<?php
namespace App\Http\Controllers;

use App\Order;
use App\User;
use App\Mail\MonthlyReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

use TANIOS\Airtable\Airtable;

class EmailController extends Controller
{

	public function ship()
    {
        $user = User::find(1);

        $airtable = new Airtable(array(
                'api_key'   => 'keyyQI5fROPrZ7QZF',
                'base'      => 'appRSXoEylxhvJ61B',
            ));
            
            $request = $airtable->getContent( 'Colaboradores/'     . $user->airtable_id);

            $response = $request->getResponse();
            $userAirtable = $response;

            if($userAirtable->fields->Situação === "Ativo")
            {
                $email = new MonthlyReport();
                $email->setUser($userAirtable);

                Mail::to($user->email)
                    ->send($email);
                echo "Email enviado para {$userAirtable->fields->Nome}<br>";
                sleep(3);
            }
            else
            {
                echo "Email não enviado pois {$userAirtable->fields->Nome} está inativo.<br>";
            }
    }

    public function mass()
    {
        $users = User::all();
        foreach ($users as $user) {

            $airtable = new Airtable(array(
                'api_key'   => 'keyyQI5fROPrZ7QZF',
                'base'      => 'appRSXoEylxhvJ61B',
            ));
            
            $request = $airtable->getContent( 'Colaboradores/'     . $user->airtable_id);

            $response = $request->getResponse();
            $userAirtable = $response;

            if($userAirtable->fields->Situação === "Ativo")
            {
                $email = new MonthlyReport();
                $email->setUser($userAirtable);

                Mail::to($user->email)
                    ->send($email);
                echo "Email enviado para {$userAirtable->fields->Nome}<br>";
                sleep(3);
            }
            else
            {
                echo "Email não enviado pois {$userAirtable->fields->Nome} está inativo.<br>";
            }
        }
    }

	/*
    public function send(){

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

    	Mail::queue('emails.send', ['title' => $title, 'content' => $content], function ($message) use ($attach)
        {
			$message->from($address, $name = null);
			$message->sender($address, $name = null);
			$message->to($address, $name = null);
			$message->cc($address, $name = null);
			$message->bcc($address, $name = null);
			$message->replyTo($address, $name = null);
			$message->subject($subject);
			$message->priority($level);
			$message->attach($pathToFile, $options);
        });

    	/*
		Mail::send('emails.send', ['title' => $title, 'content' => $content], function ($message)
        {

        });
        **
	}
	*/
}
