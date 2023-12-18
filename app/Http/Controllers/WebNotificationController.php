<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class WebNotificationController extends Controller
{
    public function store(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $user->web_token = $request->token;
        $user->save();
        return response()->json(['Token successfully stored.']);
    }


}
