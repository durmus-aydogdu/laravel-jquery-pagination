<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        return view('users');
    }

    public function showUsers() {
        $users = User::paginate(25);
        return response()->json($users);
    }
}
