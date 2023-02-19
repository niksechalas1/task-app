<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show()
    {
        $user = auth()->user();

        return view('users.show', compact('user'));
    }
    public function update(Request $request)
    {
        $user = auth()->user();
        $postData = $request->all();
        if ($postData) {
            $userData = User::find($user->id);
            if ($userData) {

                $userData->email = $postData['email'];
                if (isset($postData['pass']) && $postData['pass']) {
                    $userData->password = bcrypt($postData['pass']);
                }
                $userData->save();
                return response()->json(['success' => true]);
            }
        }

        return response()->json(['success' => false]);
    }
}
