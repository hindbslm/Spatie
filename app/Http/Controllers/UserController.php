<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Service\UserService;

class UserController extends Controller
{
    public function index()
    {
        return UserService::index();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required',
        ]);
        return UserService::create($request);
    }

    public function show($id)
    {
        return UserService::one($id);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:password_confirmation',
            'password_confirmation' => 'required',
            'roles' => 'required'
        ]);
        return UserService::edit($request,$id);
    }

    public function destroy($id)
    {
        return UserService::delete($id);
    }
}
