<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CsrfTokenController extends Controller
{
    public function getToken(Request $request)
    {
        // Pobierz token CSRF z sesji Laravel
        $token = csrf_token();

        // Umieść token w ciasteczku, aby można go było odczytać po stronie klienta
        return response()->json(['token' => $token])->cookie('XSRF-TOKEN', $token);
    }
}