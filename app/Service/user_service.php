<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService {

    static function create(Request $request){

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($input['roles']);

        return response()->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
}
