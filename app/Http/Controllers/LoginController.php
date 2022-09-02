<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct() {
        $this->middleware('guest');
    }

    public function index() {
        return view('pages.login');
    }

    public function login(Request $request) {
        return $this->responseJson(Auth::attempt($request->only(['email', 'password'])));
    }
}
