<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Hash;
use App\Models\Event;
use App\Models\Category;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    public function resetPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $randomPassword = Str::random(4) . mt_rand(1000, 9999);
        $user->update([
            'password' => bcrypt($randomPassword),
        ]);

        $emailController = new EmailController();
        $response = $emailController->sendEmailResetPassword($user->email, $randomPassword, $user->name, $user->surname);

        return response()->json(['message' => 'Hasło użytkownika zresetowane']);
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

    public function indexOrganizers() {
        $organizers = User::whereHas('rank', function ($query) {
            $query->where('name', 'organizer');
        })->get();

        return response()->json($organizers);
    }

    public function storeOrganizer(Request $request) {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
        ]);

        $randomPassword = Str::random(4) . mt_rand(1000, 9999);

        // set role manually
        // 2 is organizer
        $request->merge([
            'rank_id' => 2,
            'password' => bcrypt($randomPassword),
        ]);

        $organizer = User::create($request->all());

        $emailController = new EmailController();
        $response = $emailController->sendEmailOrganizerFirstLogin($request->email, $randomPassword, $request->name, $request->surname);

        return response()->json($organizer, 201);
    }

    public function destroyOrganizer($id) {
        $user = User::find($id);
        if($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function updateOrganizer(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json(['message' => 'Dane użytkownika zaktualizowane']);
    }

    public function updateJuror(Request $request, $id) {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'phone_number' => 'required',
            'email' => 'required|email'
        ]);

        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json(['message' => 'Dane użytkownika zaktualizowane']);
    }

    public function singleOrganizer($id) {
        $organizer = User::findOrFail($id);
        return response()->json($organizer);
    }

    public function organizerEvents($userId) {
        // Pobierz wydarzenia przypisane do organizatora
        $organizerEvents = Event::where('user_id', $userId)->get();

        // Pobierz dane organizatora
        $organizer = User::findOrFail($userId);
    
        // Pobierz użytkowników z rangą 'juror' (rank_id = 3) przypisanych do wydarzeń organizatora
        $jurors = User::where('rank_id', 3)->whereIn('event_id', $organizerEvents->pluck('id'))->get();
    
        // Pobierz użytkowników z rangą 'member' (rank_id = 4) przypisanych do wydarzeń organizatora
        $members = User::where('rank_id', 4)->whereIn('event_id', $organizerEvents->pluck('id'))->get();
    
        // Zwróć odpowiedź JSON z wszystkimi danymi
        return response()->json([
            'organizer' => $organizer,
            'events' => $organizerEvents,
            'jurors' => $jurors,
            'members' => $members,
        ]);
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
            'categories' => 'required|array',
        ]);

        $validatedData = $request->validate([
            'categories' => 'required|array',
        ]);

        $randomPassword = Str::random(4) . mt_rand(1000, 9999);

        // set role manually
        // 3 is juror
        $request->merge([
            'rank_id' => 3,
            'password' => bcrypt($randomPassword),
        ]);

        $juror = User::create($request->all());

        // Przypisanie kategorii do jurora
        $juror->categories()->sync($validatedData['categories']);

        $emailController = new EmailController();
        $response = $emailController->sendEmailJurorFirstLogin($request->email, $randomPassword, $request->name, $request->surname);

        return response()->json($juror, 201);
    }

    public function destroyJuror($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function checkChangePassword(Request $request, $id)
    {
        // get password from database
        $user = User::findOrFail($id);
        $oldPassword = $user->password;
        $newPassword = $request->newPassword;

        if (Hash::check($newPassword, $oldPassword)) {
            return response()->json(['message' => 'Hasło użytkownika nie zostało zmienione'], 400);
        } else {
            $user->update([
                'new_password' => bcrypt($newPassword),
            ]);
            return response()->json(['message' => 'Hasło użytkownika jest nowe']);
        }
    }

    public function setNewPassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if(Hash::check($request->oldPassword, $user->password)) {
            $user->update([
                'password' => $user->new_password,
                'new_password' => null,
            ]);
            return response()->json(['message' => 'Stare hasło jest poprawne']);
        } else {
            return response()->json(['message' => 'Stare hasło jest niepoprawne'], 400);
        }
    }

    public function saveNewPassword(Request $request)
    {
        $user = User::findOrFail($request->userId);

        $user->update([
            'password' => bcrypt($request->newPassword),
            'first_login' => 0,
        ]);

        return response()->json(['message' => 'Hasło użytkownika zostało zmienione']);
    }

    public function indexJurorsAdmin() {
        $jurors = User::whereHas('rank', function ($query) {
            $query->where('name', 'juror');
        })->get();

        return response()->json($jurors);
    }
}