<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function indexJurors($eventId)
    {
        $jurors = User::whereHas('rank', function ($query) {
            $query->where('name', 'juror');
        })->where('event_id', $eventId)->get();

        return response()->json($jurors);
    }

    public function storeJuror(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'event_id' => 'required',
        ]);

        $randomPassword = Str::random(4) . mt_rand(1000, 9999);

        // trzeba będzie jeszcze automatycznie wysyłać maila z hasłem

        // set role manually
        // 2 is juror
        $request->merge([
            'rank_id' => 2,
            'password' => bcrypt($randomPassword),
        ]);

        $juror = User::create($request->all());

        return response()->json($juror, 201);
    }
}