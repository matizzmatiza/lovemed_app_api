<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmailJurorFirstLogin($email, $tempPassword, $name, $surname)
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

    public function sendEmailResetPassword($email, $tempPassword, $name, $surname)
    {
        $emailData = [
            'to' => $email,
            'subject' => 'Resetowanie hasła',
            'tempPassword' => $tempPassword,
            'name' => $name,
            'surname' => $surname,
        ];

        Mail::send('emails.reset_password', $emailData, function ($message) use ($emailData) {
            $message->to($emailData['to']);
            $message->subject($emailData['subject']);
        });

        return "E-mail wysłany pomyślnie!";
    }

    public function sendEmailOrganizerFirstLogin($email, $tempPassword, $name, $surname)
    {
        $emailData = [
            'to' => $email,
            'subject' => 'Dane logowania do systemu - ORGANIZATOR',
            'tempPassword' => $tempPassword,
            'name' => $name,
            'surname' => $surname,
        ];

        Mail::send('emails.organizer_first_login', $emailData, function ($message) use ($emailData) {
            $message->to($emailData['to']);
            $message->subject($emailData['subject']);
        });

        return "E-mail wysłany pomyślnie!";
    }

    public function sendEmailVerificationCode($email, $verificationCode)
    {
        $emailData = [
            'to' => $email,
            'subject' => 'Kod weryfikacyjny',
            'verificationCode' => $verificationCode,
        ];

        Mail::send('emails.new_email_verification_code', $emailData, function ($message) use ($emailData) {
            $message->to($emailData['to']);
            $message->subject($emailData['subject']);
        });

        return "E-mail wysłany pomyślnie!";
    }
}