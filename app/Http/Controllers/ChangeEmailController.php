<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\EmailController;

class ChangeEmailController extends Controller
{
    public function changeEmail(Request $request, $userId)
    {

        $user = User::find($userId);

        if($user->verification_code === $request->verificationCode) {
            $user->email = $user->new_email;
            $user->save();
            return response()->json([
                'message' => 'Email changed successfully',
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'message' => 'Wrong verification code',
            ], 400);
        }
    }

    public function emailVerification(Request $request, $userId)
    {
        // find user and save email_verified_at and new_email
        $user = User::find($userId);
        $user->email_verified_at = now();
        $user->new_email = $request->email;
        $user->save();

        // generate verification code and send email and save in column verification_code
        $verification_code = rand(100000, 999999);
        $user->verification_code = $verification_code;
        $user->save();

        // send email
        $emailController = new EmailController();
        $response = $emailController->sendEmailVerificationCode($request->email, $verification_code);

        // $user = User::find($userId);
        // $user->email_verified_at = now();
        // $user->save();
        // return response()->json([
        //     'message' => 'Email verified successfully',
        //     'user' => $user
        // ], 200);
    }
}