<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail($email, $tempPassword, $name, $surname)
    {
        $emailData = [
            'to' => $email,
            'subject' => 'Dane logowania do systemu - JUROR',
            'tempPassword' => $tempPassword,
            'name' => $name,
            'surname' => $surname,
        ];

        Mail::send('emails.juror_first_login', $emailData, function ($message) use ($emailData) {
            $message->to($emailData['to']);
            $message->subject($emailData['subject']);
        });

        return "E-mail wysłany pomyślnie!";
    }
}