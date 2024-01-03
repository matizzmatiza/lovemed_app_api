<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'phone_number' => 'required',
            // Walidacja emaila z opcjonalnym potwierdzeniem
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json(['message' => 'Dane użytkownika zaktualizowane']);
    }

    public function changeEmail(Request $request) 
    {
        $user = Auth::user();
        $user->new_email = $request->email;
        // Generuj kod weryfikacyjny
        $user->verification_code = Str::random(6);
        $user->save();
      
        // Wysyłaj email z kodem
        Mail::to($user->new_email)->send(new VerificationCodeMail($user->verification_code));
      
        return response()->json(['success' => true]);
    }

    public function verifyCode(Request $request)
    {
        $user = Auth::user();
        if ($user->verification_code == $request->code) {
            $user->email = $user->new_email;
            $user->email_verified_at = now();
            $user->save();
        
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false]);
    } 
}