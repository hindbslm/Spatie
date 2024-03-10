<?php

namespace App\Service;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as ModelsRole;

class UserService {

    static function index(){

        $users = User::latest()->paginate(5);
        return response()->json(['users' => $users], 200);
    }

    static function one($id){
        try {
            $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['user' => $user], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    static function create(Request $request){
        try {
            DB::transaction(function() use($request) {
                $role = ModelsRole::findByName("User");

                $input = $request->all();
                $input['password'] = Hash::make($input['password']);

                $user = User::create($input);
                $user->assignRole($role);

                return response()->json(['message' => 'User created successfully', 'user' => $user], 200);
            });
        } catch (\Throwable $th) {
            return response()->json(['message' => $th->getMessage()], 500);
        }
    }

    static function edit(Request $request, $id){
        try {
            $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        } else {
            unset($input['password']);
        }

        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();
        $user->assignRole($request->input('roles'));

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
        } catch (\Throwable $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }

    }

    static function delete($id){
        try{
            $user = User::find($id);
            if (!$user) {
                return response()->json(['message' => 'User not found'], 404);
            }

            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        }catch(\Throwable $e){
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

}
